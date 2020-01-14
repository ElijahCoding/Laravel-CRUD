<?php

namespace App\Http\Controllers;

use App\Http\Resources\Image as ImageResource;
use App\Http\Resources\ImageCollection;

class ImageController extends Controller
{
    public function index()
    {
        return new ImageCollection(request()->user()->images);
    }

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
