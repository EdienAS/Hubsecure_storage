<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\WithFaker;

trait TeamFolderTestData
{
    use WithFaker;
    /**
     */
    public function createTeamFolderTestData($email = null)
    {
        $data = [
            'uuid'        =>  'uuid',
            'name'        =>  'testTeamFolderName',
            'invitations' =>  array(array(
                'email'   => $email ? $email : 'test@mail.com',
                'permission' => 'can-edit',
                'type' => 'invitation'
            ))
        ];
        
        return $data;

    }

    /**
     */
    public function updateTeamFolderTestData($userId)
    {
        $data = [
            '_method' => 'patch',
            'invitations' =>  array(array(
                'email'   => 'test+1@mail.com',
                'permission' => 'can-edit',
                'type' => 'invitation'
            )),
            'members' => array(array(
               'permission' => 'owner',
                'id' => $userId
            ))
        ];
        
        return $data;

    }
}