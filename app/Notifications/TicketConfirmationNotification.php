<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketConfirmationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        \Log::info('Notification triggered for ticket ID: '. $this->ticket->id);

        return (new MailMessage)
        ->subject('Ticket Confirmation')
        ->greeting('Hello ' . $notifiable->name . ',')
        ->line('Your ticket has been successfully created.')
        ->line('Ticket ID: ' . $this->ticket->id)
        ->line('Title: ' . $this->ticket->title)
        ->line('Description: ' . $this->ticket->description)
        ->action('View Ticket', url('/tickets/' . $this->ticket->id))
        ->line('Thank you for using our support system!');
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
            'ticket_id' => $this->ticket->id,
            'ticket_title' => $this->ticket->title,
        ];
    }
}
