<?php

namespace App\Http\Controllers;

use App\Http\Resources\Image as ImageResource;

class ImageController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'image' => 'required',
            'body' => 'required',
        ]);

        $image = $data['image']->store('images', 'public');

        $image = request()->user()->images()->create([
            'body' => $data['body'],
            'image' => $image
        ]);

        return new ImageResource($image);
    }
}
