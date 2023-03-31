<?php
namespace App\Containers\Teams\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TeamMembersCollection extends ResourceCollection
{
    public $collects = TeamMemberResource::class;

    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
