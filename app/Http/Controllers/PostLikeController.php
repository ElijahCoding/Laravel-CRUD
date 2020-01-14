<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\Post as PostResource;

class PostLikeController extends Controller
{
    public function store(Post $post)
    {
        $post = $post->like();

        return new PostResource($post);
    }
}
