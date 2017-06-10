<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers;

use App\Idea;
use App\User;

class UserController extends Controller
{
    public function profile($id)
    {
        $ideas = Idea::where('user_id', $id)->get();
        $user = User::where('id', $id)->firstOrFail();
        return view('profile', compact('user', 'ideas'));
    }
}