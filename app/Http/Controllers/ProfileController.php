<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Follow;

class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($id)
    {
        $posts = Post::where('user_id', $id)->get();
        $user = User::find($id);
        $following = Follow::where('user_id', $id)->get();
        $follow_by = Follow::where('following_user_id', $id)->get();
        return view('profile', ['posts' => $posts, 'user' => $user, 'following' => $following, 'follow_by' => $follow_by]);
    }
}
