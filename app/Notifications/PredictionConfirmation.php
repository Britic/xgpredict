<?php

namespace App\Notifications;

use App\Models\Round;
use App\Models\Services\RoundService;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PredictionConfirmation extends Notification
{
    use Queueable;

    private Round $round;
    private User $user;
    private RoundService $rs;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Round $round, User $user)
    {
        $this->round = $round;
        $this->user = $user;
        $this->rs = new RoundService($round);
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
        return (new MailMessage)
            ->subject('Predictions Confirmation')
            ->markdown('mails.predictions.confirmation', [
                'name' => $notifiable->name,
                'userPredictions' => $this->rs->getUserRoundPredictions($notifiable)
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
}
