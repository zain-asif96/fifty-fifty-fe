<?php

namespace App\Notifications;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioMessage;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public Transaction $transaction;
    public string $text;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction, $text)
    {
        $this->transaction = $transaction;
        $this->text = $text;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(User $notifiable): array
    {
        if (app()->environment() !== 'production') return ['mail', 'telegram'];

        return ['mail', TwilioChannel::class, 'telegram'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line($this->text)
            ->action('Track transaction', url('/tt?t=' . $this->transaction->id))
            ->line('Your FiftyFifty transaction serial number: ' . $this->transaction->id)
            ->line('Thank you for using 50-50!');
    }

    public function toTwilio(User $notifiable): TwilioSmsMessage|TwilioMessage
    {
        return (new TwilioSmsMessage())
            ->content("$this->text . ', Your FiftyFifty transaction serial number: " . $this->transaction->id);
    }

    public function toTelegram(User $notifiable): TelegramMessage
    {
        $pre = "This message is intended to: $notifiable->first_name $notifiable->last_name \n\n";

        return TelegramMessage::create()
            ->to(config('services.telegram-bot-api.chat_id'))
            ->content($pre . $this->text . ', Your FiftyFifty transaction serial number: ' . $this->transaction->id)
            ->button('Track Transaction', url('/tt?t=' . $this->transaction->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray(User $notifiable): array
    {
        return [
            //
        ];
    }
}
