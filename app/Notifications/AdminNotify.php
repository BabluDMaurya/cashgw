<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminNotify extends Notification
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
        if($this->notify['action'] == 'request'){
            $mess = config('constants.SendRequestToAdmin');
        }elseif($this->notify['action'] == 'recived'){
            if($this->notify['process'] == 3){
                $mess = config('constants.RequestRejectPaymentNotification');
            }else{
               $mess = config('constants.RecivedNotificationFromAdmin'); 
            }            
        }elseif($this->notify['action'] == 'contactsend'){
            if($this->notify['process'] == 1){
                $mess = config('constants.ContactSend');
            }
        }
        return [          
            'message' => $mess,
            'action'=>$this->notify['action'],
            'process'=>$this->notify['process'],
            'type'=>$this->notify['type'],
            'tab'=>$this->notify['tab'],
        ];
    }
}
