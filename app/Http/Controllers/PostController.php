<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\Post as PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return new PostCollection(request()->user()->posts);
    }


    public function store()
    {
        $data = request()->validate([
            'body' => 'required'
        ]);

        $post = request()->user()->posts()->create([
            'body' => $data['body']
        ]);

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        $this->authorize('touch', $post);

        return new PostResource($post);
    }

    public function update(Post $post)
    {
        $this->authorize('touch', $post);

        $data = request()->validate([
            'body' => 'required'
        ]);

        $post->update([
            'body' => $data['body']
        ]);

        return new PostResource($post->fresh());
    }

    public function destroy(Post $post)
    {
        //
    }
}
