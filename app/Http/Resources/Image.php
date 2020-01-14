<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
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
                'type' => 'images',
                'image_id' => $this->id,
                'attributes' => [
                    'posted_by' => new UserResource($this->user),
                    'body' => $this->body,
                    'image' => url($this->image),
                    'created_at' => $this->created_at->diffForHumans()
                ]
            ],
            'links' => [
                'self' => url('/images/' . $this->id)
            ]
        ];
    }
}
