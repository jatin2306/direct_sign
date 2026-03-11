<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Property;
use Illuminate\Support\Facades\Log;

class PriceDropNotification extends Notification
{
    public $propertyId;  // Store only the property ID
    public $oldPrice;
    public $newPrice;
    public $property;   // Store the property object early

    public function __construct($propertyId, $oldPrice = null, $newPrice = null)
    {   
        $this->propertyId = $propertyId;  // Save only the property ID
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
        // Fetch property at the time of notification creation
        //$this->property = Property::find($propertyId);
    }
        

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $property = Property::with('childTypeRelation')->find($this->propertyId);
        if ($property) {
            return (new MailMessage)
                ->subject('Price Drop Alert: ' . $property->propertyName)
                ->line('The price has dropped from ' . number_format($this->oldPrice, 2) . ' to ' . number_format($this->newPrice, 2) . '!')
                ->action('View Property', route('property.show', $property->slug))
                ->line('Act fast before it’s gone!');
        } else {
            Log::error('Property or Property name is missing in PriceDropNotification for Property ID: ' . $this->propertyId);
            return (new MailMessage)
                ->subject('Price Drop Alert')
                ->line('The price has dropped, but we couldn’t find the property details.');
        }
    }

    public function toArray($notifiable)
    {
        $property = Property::with('childTypeRelation')->find($this->propertyId);
        if ($property) {
            return [
                'property_id' => $property->id,
                'message' => 'The price for ' . $property->propertyName . ' has dropped!',
                'url' => route('property.show', $property->slug),
            ];
        } else {
            Log::error('Property is missing in toArray for notification with ID: ' . $this->propertyId);
            return [
                'message' => 'The price has dropped, but we couldn’t find the property details.',
                'url' => null,
            ];
        }
    }
}
