<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Follow;

class ProfileController extends Controller
{

    public function __construct(){
        // $this->middleware('auth');
    }

    public function index($id)
    {
        $user = User::with('post')
          ->withCount([
            'follows' => function($query){ $query->where('is_check', 1); },
            'follow_by' => function($query){ $query->where('is_check', 1); },
          ])->find($id);

        $follows = Follow::with('user')->where('following_user_id', auth()->id())->where('is_check', 0)->get();
        return view('profile', ['user' => $user, 'follows' => $follows]);
    }
}
