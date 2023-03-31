<?php

namespace App\Containers\Share\Tasks;

use App\Containers\Share\Exceptions\ShareItemException;
use App\Abstracts\Task;
use App\Containers\User\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Containers\Share\Notifications\SharedSendViaEmail;

/**
 * Class ShareItemSendViaEmailTask.
 *
 */
class ShareItemSendViaEmailTask extends Task
{
    /**
     * @param $request
     *
     * @return mixed
     */
    public function execute(array $emails, string $token, User $user)
    {
        try {
            
            // Get default app locale
            $appLocale = get_settings('language') ?? 'en';

            foreach ($emails as $email) {
                Notification::route('mail', $email)
                    ->notify(
                        (new SharedSendViaEmail($token, $user, ['mail']))->locale($appLocale)
                    );

                $receiver = User::where('email', $email)
                        ->whereNotIn('email', [$user->email])->first();
                
                if(isset($receiver->id) && !empty($receiver->id)){
                    
                    $receiver->notify(
                        (new SharedSendViaEmail($token, $user, ['database', 'broadcast']))->locale($appLocale)
                    );
                }
            }

        } catch (\Exception $e) {
            throw (new ShareItemException())->debug($e);
        }
        
    }
    
}
