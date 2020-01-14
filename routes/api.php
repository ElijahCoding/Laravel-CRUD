<?php

Route::middleware('auth:api')->group(function () {
    Route::apiResources([
        '/posts' => 'PostController',
        '/images' => 'ImageController'
    ]);
});
