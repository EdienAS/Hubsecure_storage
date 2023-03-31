<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;
use App\Containers\UserSettings\Models\Usersetting;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait UserSettingsTestData
{
    use WithFaker;
    /**
     * @param int $userId
     */
    public function userSettingsTestData($userId)
    {
        return Usersetting::factory()->count(1)->state(new Sequence(
                    ['user_id' => $userId, 
                        'file_storage_option_id' => 1,
                        'storage_limit_mb' => rand(1,100),
                        'client_encryption_key' => env('XRPL_CLIENT_ENCRYPTION_KEY'),
                        'client_wallet_seed' => env('XRPL_CLIENT_WALLET_SEED'),
                        'client_wallet_seq' => env('XRPL_CLIENT_WALLET_SEQ')
                    ]
                ))->create();

    }

}