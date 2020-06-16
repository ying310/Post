<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;

class FirstController extends Controller
{
    public function index(){
        if(auth()->check()){
          $user = User::where('id', auth()->id())->first();
          $follow = $user->follows->pluck('id');
          $follow = $follow->push(auth()->id());
          $posts = Post::with(['user:id,name', 'like'=> function($query){ $query->where('user_id', auth()->id())->where('type', 1); }])
          ->withCount(['like' => function($query){ $query->where('type', 1); }])
          ->whereIn('user_id', $follow)->latest()->get();
          return view('first', ['posts' => $posts]);
        }else{
          return view('first');
        }
    }

    
}
