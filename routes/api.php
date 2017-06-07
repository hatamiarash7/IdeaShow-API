<?php

Route::resource('/v1/users', v1\UserController::class, [
    'except' => [
        'create',
        'edit'
    ]
]);