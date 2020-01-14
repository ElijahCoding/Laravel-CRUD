<?php

namespace App\Policies;

use App\Models\{User, Post};
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function touch(User $user, Post $post)
    {
        return $user->id === (int)$post->user_id;
    }
}
