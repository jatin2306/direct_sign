<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BannerController extends Controller
{
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
            'image_display'   => 'nullable|string',
            'text_placement'  => 'nullable|string|in:left,right,center',
            'sort_order'      => 'nullable|integer|min:0',
            'is_active'       => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $dimensions = @getimagesize($file->getPathname());
            if (! $dimensions || $dimensions[0] !== 1280 || $dimensions[1] !== 400) {
                return redirect()->back()
                    ->withErrors(['image' => 'The banner image must be exactly 1280 × 400 pixels.'])
                    ->withInput();
            }
        }

        $validated['sort_order'] = (int) ($request->input('sort_order', 0));
        $validated['text_placement'] = $request->input('text_placement', 'left');
        $validated['is_active'] = $request->boolean('is_active', true);

        if (Banner::where('sort_order', $validated['sort_order'])->exists()) {
            return redirect()->back()->withErrors(['sort_order' => 'Sort order already exists.'])->withInput();
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move($this->bannerStoragePath(), $name);
            $validated['image'] = 'banners/' . $name;
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

        Banner::create($validated);
        return redirect()->route('admin.banners.index')->with('success', 'Banner added.');
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
            $name = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move($this->bannerStoragePath(), $name);
            $validated['image'] = 'banners/' . $name;
        } else {
            unset($validated['image']);
        }

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
