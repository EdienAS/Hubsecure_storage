<?php
namespace App\Containers\User\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id'            => $this->id,
                'type'          => 'user',
                'attributes'    => [
                    'name'                      => $this->name,
                    'color'                     => $this->userSettings->color,
                    'avatar'                    => $this->avatar_url,
                    'email'                     => $this->email,
                    'role'                      => $this->role->title,
                    'storage'                   => $this->storage,
                    'created_at'                => format_date($this->created_at, 'd. M. Y'),
                    'updated_at'                => format_date($this->updated_at, 'd. M. Y'),
                ],
                'relationships' => [
                    'settings'            => new SettingsResource($this->userSettings),
                    
                ],
                'meta'          => [
                    'restrictions' => [
                        'canUpload'            => $this->canUpload(),
                        'canDownload'          => $this->canDownload(),
                        'canCreateFolder'      => $this->canCreateFolder(),
                        'canCreateTeamFolder'  => $this->canCreateTeamFolder(),
                        'canInviteTeamMembers' => $this->canInviteTeamMembers(),
                        'reason'               => $this->getRestrictionReason(),
                    ],
                ],
            ],
        ];
    }

}
