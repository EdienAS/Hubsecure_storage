<?php
namespace App\Containers\Teams\Notifications;

use Illuminate\Bus\Queueable;
use App\Containers\User\Models\User;
use App\Containers\Folders\Models\Folder;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Traits\NotificationRepresentationArray;
use Illuminate\Notifications\Messages\MailMessage;
use App\Containers\Teams\Models\TeamFolderInvitation;

class InvitationIntoTeamFolder extends Notification implements ShouldQueue
{
    use Queueable, NotificationRepresentationArray;

    public function __construct(
        public Folder $teamFolder,
        public TeamFolderInvitation $invitation,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        $appTitle = env('APP_NAME');

        // Try to find the user via email
        $user = User::where('email', $this->invitation->email)
            ->first();

        if ($user) {
            return (new MailMessage)
                ->subject('You are invited to collaboration with team folder in :app', ['app' => $appTitle])
                ->greeting('Hello!')
                ->line('You are invited to collaboration with team folder. Login to proceed into team folder.')
                ->action('Login', url(env('FRONTEND_URL'). config('constants.frontend_endpoints.sign_in')))
                ->salutation('Regards' . ', ' .  $appTitle);
        }

        return (new MailMessage)
            ->subject('You are invited to collaboration with team folder in ' . $appTitle)
            ->greeting('Hello!')
            ->line('You are invited to collaboration with team folder. But at first, you have to create an account to proceed into team folder.')
            ->action('Join & Create an Account', url(env('FRONTEND_URL'). config('constants.frontend_endpoints.sign_up')))
            ->salutation('Regards' . ', ' .  $appTitle);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array
    {
        return $this->notificationRepresentationArray('team-invitation', 'New Team Invitation', 
                $this->invitation->inviter->name . ' invited you to join into Team Folder.', 
                'invitation', $this->invitation->uuid);
    }
}
