<?php
namespace App\Containers\Notifications\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    public $collects = NotificationResource::class;

    public function toArray($request): array
    {
        return [
            'items' => $this->collection,
        ];
    }
}
