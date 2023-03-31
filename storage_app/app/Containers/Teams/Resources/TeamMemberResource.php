<?php
namespace App\Containers\Teams\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamMemberResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => [
                'id'         => $this->id,
                'type'       => 'member',
                'attributes' => [
                    'email'      => $this->email,
                    'name'       => $this->name,
                    'avatar'     => $this->userSettings->avatar,
                    'color'      => $this->userSettings->color,
                    'permission' => $this->pivot->permission,
                ],
            ],
        ];
    }
}
