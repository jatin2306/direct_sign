<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\PriceDropNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Property;

class NotificationController extends Controller
{

    public function subscribeForPriceDrop($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $user = auth()->user();

        // Check if already subscribed
        if ($user->subscribedProperties()->where('property_id', $propertyId)->wherePivot('notification_type', 'price_drop')->exists()) {
            return back()->with('message', 'You are already subscribed for price drop alerts.');
        }

        // Subscribe user
        $user->subscribedProperties()->attach($propertyId, ['notification_type' => 'price_drop']);

        return back()->with('message', 'You will be notified when the price drops.');
    }


}
