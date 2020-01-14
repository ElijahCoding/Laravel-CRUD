<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    public function touch(User $user, Image $image)
    {
        return $user->id === (int)$image->user_id;
    }
}
