<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RequestPayment extends Notification
{
    use Queueable;
     private $notify;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifiable)
    {
        $this->notify = $notifiable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if($this->notify['action'] == 'accept'){
            $mess = config('constants.RequestAcceptPaymentNotification');
        }elseif($this->notify['action'] == 'rejected'){
            $mess = config('constants.RequestRejectPaymentNotification');
        }else{
            $mess = config('constants.RequestPaymentNotification');
        }
        return [          
            'balance'=> $this->notify['balance'],
            'currency_requested'=> $this->notify['currency_requested'],
            'message' => $mess,
            'action'=>$this->notify['action'],
            'process'=>$this->notify['process'],
            'tab'=>$this->notify['tab'],
        ];
    }
}
