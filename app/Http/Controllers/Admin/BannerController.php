<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class BannerController extends Controller
{
    private const BANNER_WIDTH = 1280;
    private const BANNER_HEIGHT = 400;
    /** Directory under public path where banner images are stored (no symlink needed). */
    private function bannerStoragePath(): string
    {
        $path = public_path('storage/banners');
        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }
        return $path;
    }

    public function index()
    {
        $banners = Banner::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'heading'         => 'nullable|string|max:255',
            'sub_heading'     => 'nullable|string|max:500',
            'cta_text'        => 'nullable|string|max:100',
            'cta_url'         => 'nullable|string|max:500',
            'image'           => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'crop_x'          => 'nullable|integer|min:0',
            'crop_y'          => 'nullable|integer|min:0',
            'crop_zoom'       => 'nullable|numeric|min:1|max:3',
            'image_display'   => 'nullable|string',
            'text_placement'  => 'nullable|string|in:left,right,center',
            'sort_order'      => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
        ]);

        $validated['sort_order'] = (int) ($request->input('sort_order', 0));
        $validated['text_placement'] = $request->input('text_placement', 'left');
        $validated['is_active'] = $request->boolean('is_active', true);

        if (Banner::where('sort_order', $validated['sort_order'])->exists()) {
            return redirect()->back()->withErrors(['sort_order' => 'Sort order already exists.'])->withInput();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $validated['image'] = $this->processBannerImage(
                $file,
                $request->input('crop_x'),
                $request->input('crop_y'),
                $request->input('crop_zoom')
            );
        }

        if (! empty($validated['image_display'])) {
            $decoded = json_decode($validated['image_display'], true);
            $validated['image_display'] = is_array($decoded) ? $decoded : null;
        } else {
            $validated['image_display'] = null;
        }

        if (! empty($validated['cta_url'])) {
            $validated['cta_url'] = html_entity_decode($validated['cta_url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        unset($validated['crop_x'], $validated['crop_y'], $validated['crop_zoom']);
        Banner::create($validated);
        return redirect()->route('admin.banners.index')->with('success', 'Banner added.');
    }

    /**
     * Save banner image: exact 1280×400 as-is; larger images cropped from (crop_x, crop_y); smaller as-is.
     * Returns relative path like 'banners/xxx.jpg'.
     */
    private function processBannerImage($file, $cropX, $cropY, $cropZoom = null): string
    {
        $dimensions = @getimagesize($file->getPathname());
        $width = $dimensions[0] ?? 0;
        $height = $dimensions[1] ?? 0;

        $ext = strtolower($file->getClientOriginalExtension());
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            $ext = 'jpg';
        }
        $name = Str::random(40) . '.' . $ext;
        $destPath = $this->bannerStoragePath() . '/' . $name;

        $zoom = is_numeric($cropZoom) ? (float) $cropZoom : 1.0;
        $zoom = max(1.0, min(3.0, $zoom));

        if ($width === self::BANNER_WIDTH && $height === self::BANNER_HEIGHT) {
            if ($zoom <= 1.0) {
                $file->move($this->bannerStoragePath(), $name);
                return 'banners/' . $name;
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getPathname());
            $cropW = (int) round(self::BANNER_WIDTH / $zoom);
            $cropH = (int) round(self::BANNER_HEIGHT / $zoom);
            $x = (int) floor((self::BANNER_WIDTH - $cropW) / 2);
            $y = (int) floor((self::BANNER_HEIGHT - $cropH) / 2);
            $image->crop($cropW, $cropH, $x, $y);
            $image->resize(self::BANNER_WIDTH, self::BANNER_HEIGHT);
            $encoded = $image->encode(new JpegEncoder(quality: 90));
            File::put($destPath, (string) $encoded);
            return 'banners/' . $name;
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getPathname());

        if ($width >= self::BANNER_WIDTH && $height >= self::BANNER_HEIGHT) {
            $cropW = (int) round(self::BANNER_WIDTH / $zoom);
            $cropH = (int) round(self::BANNER_HEIGHT / $zoom);
            $cropW = max(1, min($width, $cropW));
            $cropH = max(1, min($height, $cropH));

            $x = 0;
            $y = 0;
            if (is_numeric($cropX) && is_numeric($cropY)) {
                $x = max(0, min($width - $cropW, (int) $cropX));
                $y = max(0, min($height - $cropH, (int) $cropY));
            } else {
                $x = (int) floor(($width - $cropW) / 2);
                $y = (int) floor(($height - $cropH) / 2);
            }
            $image->crop($cropW, $cropH, $x, $y);
            if ($cropW !== self::BANNER_WIDTH || $cropH !== self::BANNER_HEIGHT) {
                $image->resize(self::BANNER_WIDTH, self::BANNER_HEIGHT);
            }
            $encoded = $image->encode(new JpegEncoder(quality: 90));
            File::put($destPath, (string) $encoded);
            return 'banners/' . $name;
        }

        if ($width < self::BANNER_WIDTH || $height < self::BANNER_HEIGHT) {
            // Small image: scale to fit inside 1280×400, place on canvas at (crop_x, crop_y)
            $scaleFit = min(self::BANNER_WIDTH / $width, self::BANNER_HEIGHT / $height);
            $scaleFit *= $zoom;
            $scaledW = (int) round($width * $scaleFit);
            $scaledH = (int) round($height * $scaleFit);
            $image->resize($scaledW, $scaledH);

            $posX = 0;
            $posY = 0;
            if (is_numeric($cropX) && is_numeric($cropY)) {
                $posX = max(0, min(self::BANNER_WIDTH - $scaledW, (int) $cropX));
                $posY = max(0, min(self::BANNER_HEIGHT - $scaledH, (int) $cropY));
            } else {
                $posX = (int) floor((self::BANNER_WIDTH - $scaledW) / 2);
                $posY = (int) floor((self::BANNER_HEIGHT - $scaledH) / 2);
            }

            $canvas = $manager->create(self::BANNER_WIDTH, self::BANNER_HEIGHT);
            $canvas->fill('#1a1a1a');
            $tempPath = $this->bannerStoragePath() . '/temp_' . $name;
            File::put($tempPath, (string) $image->encode(new JpegEncoder(quality: 90)));
            $canvas->place($tempPath, 'top-left', $posX, $posY);
            File::delete($tempPath);
            $encoded = $canvas->encode(new JpegEncoder(quality: 90));
            File::put($destPath, (string) $encoded);
            return 'banners/' . $name;
        }

        $file->move($this->bannerStoragePath(), $name);
        return 'banners/' . $name;
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'heading'         => 'nullable|string|max:255',
            'sub_heading'     => 'nullable|string|max:500',
            'cta_text'        => 'nullable|string|max:100',
            'cta_url'         => 'nullable|string|max:500',
            'image'           => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
            'crop_x'          => 'nullable|integer|min:0',
            'crop_y'          => 'nullable|integer|min:0',
            'crop_zoom'       => 'nullable|numeric|min:1|max:3',
            'image_display'   => 'nullable|string',
            'text_placement'  => 'nullable|string|in:left,right,center',
            'sort_order'      => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
        ]);

        $validated['sort_order'] = (int) ($request->input('sort_order', 0));
        $validated['text_placement'] = $request->input('text_placement', 'left');
        $validated['is_active'] = $request->boolean('is_active', true);

        if (Banner::where('sort_order', $validated['sort_order'])->where('id', '!=', $banner->id)->exists()) {
            return redirect()->back()->withErrors(['sort_order' => 'Sort order already exists.'])->withInput();
        }

        if ($request->hasFile('image')) {
            if ($banner->image) {
                $oldPath = public_path('storage/' . $banner->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $file = $request->file('image');
            $validated['image'] = $this->processBannerImage(
                $file,
                $request->input('crop_x'),
                $request->input('crop_y'),
                $request->input('crop_zoom')
            );
        } else {
            unset($validated['image']);
        }
        unset($validated['crop_x'], $validated['crop_y'], $validated['crop_zoom']);

        if (array_key_exists('image_display', $validated)) {
            if (! empty($validated['image_display'])) {
                $decoded = json_decode($validated['image_display'], true);
                $validated['image_display'] = is_array($decoded) ? $decoded : null;
            } else {
                $validated['image_display'] = null;
            }
        }

        if (! empty($validated['cta_url'])) {
            $validated['cta_url'] = html_entity_decode($validated['cta_url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        $banner->update($validated);
        return redirect()->route('admin.banners.index')->with('success', 'Banner updated.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if ($banner->image) {
            $path = public_path('storage/' . $banner->image);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted.');
    }
}
