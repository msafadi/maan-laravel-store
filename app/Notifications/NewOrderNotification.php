<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

class NewOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
        
        // mail, database, broadcast, nexmo (sms), slack
        $via = ['database'];
        if ($notifiable->notify_mail) {
            $via[] = 'mail';
        }
        if ($notifiable->notify_sms) {
            $via[] = 'nexmo';
        }
        if ($notifiable->notify_broadcast) {
            $via[] = 'broadcast';
        }
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage;
        $message
            ->subject('New Order')
            ->from('notify@localhost', 'Maan Billing')

            ->greeting('Hello, ' . ($notifiable->name ?? ''))
            ->line('A new order created.')
            ->action('View Order', url('/'))
            ->line('Thank you for using our application!')
            ->view('mails.new-order', [
                'name' => ($notifiable->name ?? ''),
                'url' => url('/'),
            ]);

        return $message;
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Order',
            'body' => 'A new order created',
            'image' => '',
            'link' => url('/'),
        ];
    }

    public function toNexmo($notifiable)
    {
        // return (new NexmoMessage)->content('A new order created');
        $message = new NexmoMessage();
        $message->content('A new order created');
        return $message;
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'New Order',
            'body' => 'A new order created',
            'image' => '',
            'link' => url('/'),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function broadcastType()
    {
        return 'NewOrder';
    }
}
