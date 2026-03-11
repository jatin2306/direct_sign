<?php

namespace App\Observers;

use App\Models\Property;
use App\Notifications\PriceDropNotification;
class PropertyObserver
{   
    public function updating(Property $property)
{
    if ($property->isDirty('price')) {
        $oldPrice = $property->getOriginal('price');
        $newPrice = $property->price;
        
        if ($newPrice < $oldPrice) {
            $this->notifyUsers($property->id, $oldPrice, $newPrice, 'price_drop');  // Pass the property ID
        }
    }
}

private function notifyUsers($propertyId, $oldPrice, $newPrice, $notificationType)
{
    $property = Property::find($propertyId);  // Fetch the property using the ID

    // Proceed with the rest of your code
    $subscribedUsers = $property->subscribers()->wherePivot('notification_type', $notificationType)->get();
    
    foreach ($subscribedUsers as $user) {
        // Pass the property ID instead of the whole Property object
        
        $user->notify(new PriceDropNotification($propertyId, $oldPrice, $newPrice));
        
        }
}



    /**
     * Handle the Property "created" event.
     */
    public function created(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "updated" event.
     */
    public function updated(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "deleted" event.
     */
    public function deleted(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "restored" event.
     */
    public function restored(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "force deleted" event.
     */
    public function forceDeleted(Property $property): void
    {
        //
    }
}
