<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/posts', [
            'body' => 'Testing Body'
        ]);

        $post = Post::first();

        $this->assertCount(1, Post::all());
        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('Testing Body', $post->body);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                        'posted_by' => [
                            'data' => [
                                'attributes' => [
                                    'name' => $user->name,
                                ]
                            ]
                        ],
                        'body' => 'Testing Body'
                    ]
                ],
                'links' => [
                    'self' => url('/posts/' . $post->id)
                ]
            ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_post()
    {
        $this->actingAs($user = factory(User::class)->create());

        $response = $this->post('/api/posts', [
            'body' => 'Testing Body'
        ])->assertStatus(302);
    }

    /** @test */
    public function a_body_is_required_to_create_a_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $post = factory(Post::class)->create();

        $response = $this->json('POST','/api/posts/', [
            'body' => ''
        ])->assertStatus(422);

        $responseString = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('body', $responseString['errors']);
    }
}
