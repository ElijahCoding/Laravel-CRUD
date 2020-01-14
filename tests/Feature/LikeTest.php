<?php

namespace Tests\Feature;

use App\Http\Resources\LikeCollection;
use App\Http\Resources\User as UserResource;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class LikeTest extends TestCase
{
    /** @test */
    public function a_user_can_like_a_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create();

        $response = $this->post('/api/posts/' . $post->id . '/like')
            ->assertStatus(200);

        $this->assertCount(1, $user->likes);

        $response->assertJson([
            'data' => [
                'type' => 'posts',
                'post_id' => $post->id,
                'attributes' => [
                    'body' => $post->body,
                    'posted_at' => $post->created_at->diffForHumans()
                ]
            ],
            'links' => [
                'self' => url('/posts/' . $post->id)
            ]
        ]);
    }
}
