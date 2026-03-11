<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyMeNotification extends Notification
{
    use Queueable;

    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {   /*
        return (new MailMessage)
            ->subject('We Will Notify You!')
            ->greeting('Hello!')
            ->line('You will be notified when properties matching your search criteria become available.')
            ->line('Filters Applied:')
            ->line('Location: ' . ($this->filters['location'] ?? 'Any'))
            ->line('Price Range: ' . ($this->filters['price'] ?? 'Any'))
            ->line('Property Type: ' . ($this->filters['propertyType'] ?? 'Any'))
            ->line('Category: ' . ($this->filters['category'] ?? 'Any'))
            ->line('Specific Type: ' . ($this->filters['childType'] ?? 'Any'))
            ->line('Bedrooms: ' . ($this->filters['bedrooms'] ?? 'Any'))
            ->line('Bathrooms: ' . ($this->filters['bathrooms'] ?? 'Any')) 
            ->line('Thank you for using our platform!');*/
    }

    public function toDatabase($notifiable)
    {
        return [
            'filters' => $this->filters,
            'message' => 'You will be notified when matching properties become available.',
        ];
    }
}
