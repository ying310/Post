<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Follow;

class ProfileController extends Controller
{
    public function index($id)
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return view('profile', ['posts' => $posts]);
    }
}
