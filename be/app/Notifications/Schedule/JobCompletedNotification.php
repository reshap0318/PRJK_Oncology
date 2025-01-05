<?php

namespace App\Notifications\Schedule;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Channel\WebhookChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    private $output;
    
    public function __construct($output)
    {
        $this->output = $output;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        $channels = [];
        if ($notifiable->notification_email) {
            $channels[] = 'mail';
        }
        // if ($notifiable->notification_webhook) {
        //     $channels[] = WebhookChannel::class;
        // }

        return $channels;
    }
    
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject($notifiable->description)
                    ->greeting('Hi Friends,')
                    ->line("{$notifiable->description} just finished running.")
                    ->line($this->output);
    }

    public function toWebhook($notifiable): array
    {
        $output = trim($this->output);

        $raw = [
            'methode' => 'post',
            'headers' => ['Content-Type' => 'application/json'],
            'body'    => [
                "title"         => "{$notifiable->description} just finished running",
                "description"   => $output,
            ]
        ];

        if(Str::contains($notifiable->notification_webhook, 'discordapp.com/api/webhooks'))
        {
            $raw['body'] = ['body' => '{
                "embeds" : [{
                    "title" : "'.$notifiable->description.' just finished running",
                    "description" : "'.$output.'",
                    "color": 14492333
                }]
            }'];
        }
        return $raw;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
