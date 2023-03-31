<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;

trait UserTestData
{
    use WithFaker;
    /**
     * @before
     */
    public function userTestData()
    {
        $data = [
            'uuid' => 'uuid',
            'name' => 'testuser name',
            'email' => 'test@mail.com',
            'password' => 'password',
            'role_id' => 2
        ];
        
        return $data;

    }

}