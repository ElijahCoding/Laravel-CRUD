<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Like extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'likes',
                'like_id' => $this->id,
                'attributes' => [
                    'likeable_type' => $this->likeable_type,
                    'likeable_id' => $this->likeable_id,
                    'created_at' => $this->created_at->diffForHumans(),
                    'liked_by' => new UserResource($this->user),
                ]
            ],
        ];
    }
}
