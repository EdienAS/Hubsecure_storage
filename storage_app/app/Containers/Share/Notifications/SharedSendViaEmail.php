<?php
namespace App\Containers\Share\Notifications;

use Illuminate\Bus\Queueable;
use App\Containers\User\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Traits\NotificationRepresentationArray;
use Illuminate\Notifications\Messages\MailMessage;

class SharedSendViaEmail extends Notification implements ShouldQueue
{
    use Queueable, NotificationRepresentationArray;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $token,
        public User $user,
        public array $channel
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->user->name . " share some files with you. Look at it!")
            ->greeting('Hello!')
            ->line($this->user->name . " send you a link to shared files.")
            ->action('Open your files.', url(env('FRONTEND_URL'). config('constants.frontend_endpoints.pages_share') . "{$this->token}"))
            ->salutation('Regards,' . PHP_EOL . "Team " . env('APP_NAME'));
    }
    
    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array
    {
        return $this->notificationRepresentationArray('share-item', 'New Share Item', 
                $this->user->name . ' has shared an item with you.', 'share', 
                $this->token);
    }
}
