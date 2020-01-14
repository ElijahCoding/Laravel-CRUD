<?php

namespace Tests\Feature;

use App\Models\{Image, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function a_user_can_create_an_image()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $file = UploadedFile::fake()->image('image.jpg');

        $response = $this->post('/api/images', [
            'body' => 'Testing Body',
            'image' => $file,
        ]);

        Storage::disk('public')->assertExists('images/' . $file->hashName());

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'body' => 'Testing Body',
                        'image' => url('images/' . $file->hashName()),
                    ]
                ],
            ]);
    }

    /** @test */
    public function a_user_can_retrieve_all_images()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $images = factory(Image::class, 2)->create(['user_id' => $user->id]);

        $response = $this->get('/api/images');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'type' => 'images',
                            'image_id' => $images->last()->id,
                            'attributes' => [
                                'body' => $images->last()->body,
                                'image' => url($images->last()->image),
                                'created_at' => $images->last()->created_at->diffForHumans()
                            ]
                        ]
                    ],
                    [
                        'data' => [
                            'type' => 'images',
                            'image_id' => $images->first()->id,
                            'attributes' => [
                                'body' => $images->first()->body,
                                'image' => url($images->first()->image),
                                'created_at' => $images->first()->created_at->diffForHumans()
                            ]
                        ]
                    ]
                ],
                'links' => [
                    'self' => url('/images'),
                ]
            ]);
    }

    /** @test */
    public function an_authenticated_user_can_retrieve_his_own_single_image()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $image = factory(Image::class)->create(['user_id' => $user->id]);

        $response = $this->get('/api/images/' . $image->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'images',
                    'image_id' => $image->id,
                    'attributes' => [
                        'body' => $image->body,
                        'image' => url($image->image),
                        'created_at' => $image->created_at->diffForHumans()
                    ]
                ],
                'links' => [
                    'self' => url('/images/' . $image->id),
                ]
            ]);
    }

    /** @test */
    public function an_authenticated_user_can_update_his_own_image()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $image = factory(Image::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->patch('/api/images/' . $image->id, [
            'body' => 'updated body',
            'image' => 'updated.image'
        ]);

        $image = $image->fresh();

        $this->assertEquals($image->body, 'updated body');
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'images',
                    'image_id' => $image->id,
                    'attributes' => [
                        'body' => $image->body,
                        'image' => url($image->image),
                        'created_at' => $image->created_at->diffForHumans()
                    ]
                ],
                'links' => [
                    'self' => url('/images/' . $image->id),
                ]
            ]);
    }

    /** @test */
    public function an_authenticated_user_can_delete_his_own_single_post()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $image = factory(Image::class)->create(['user_id' => $user->id]);

        $response = $this->delete('/api/images/' . $image->id);

        $this->assertCount(0, Image::all());
        $response->assertStatus(200);
    }
}
