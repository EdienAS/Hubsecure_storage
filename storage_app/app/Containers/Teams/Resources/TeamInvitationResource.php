<?php
namespace App\Containers\Teams\Resources;

use App\Containers\User\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamInvitationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => [
                'id'            => $this->id,
                'type'          => 'invitation',
                'attributes'    => [
                    'parent_id'     => $this->parent_folder_id,
                    'email'         => $this->email,
                    'color'         => $this->color,
                    'status'        => $this->status,
                    'permission'    => $this->permission,
                    'isExistedUser' => User::where('email', $this->email)->exists(),
                ],
                'relationships' => [
                    $this->mergeWhen($this->inviter, fn () => [
                        'inviter' => [
                            'data' => [
                                'type'       => 'user',
                                'id'         => $this->inviter->id,
                                'attributes' => [
                                    'name'   => $this->inviter->name,
                                    'avatar' => $this->inviter->userSettings->avatar,
                                    'color'  => $this->inviter->userSettings->color,
                                ],
                            ],
                        ],
                    ]),
                ],
            ],
        ];
    }
}
