<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Resources\Image as ImageResource;

class ImageLikeController extends Controller
{
    public function store(Image $image)
    {
        $image = $image->like();

        return new ImageResource($image);
    }
}
