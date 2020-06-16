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
        $user = User::with('post')
          ->withCount([
            'follows' => function($query){ $query->where('is_check', 1); },
            'follow_by' => function($query){ $query->where('is_check', 1); },
          ])->find($id);

        $follows = Follow::with('user')->where('following_user_id', auth()->id())->where('is_check', 0)->get();
        return view('profile', ['user' => $user, 'follows' => $follows]);
    }

    public function search(Request $request){
        $request->validate([
            'search' => 'required'
        ], [
          'search.required' => '搜尋不能空白'
        ]);
        $name = $request->input('search');
        $name = "%". $name . "%";
        $users = User::where('name', 'like', $name)->get();
        return view('search', ['users' => $users]);
    }

    public function nameComplete(Request $request){
        if($request->ajax()){
            $search = $request->input('search');
            $users = User::where('name', 'like', '%'.$search.'%')->take(10)->get();
            if($users->isEmpty()){
                $output = '沒有結果';
            }else{
                $output = '<ul class="dropdown-menu" style="width:100%;display:block;position:absolute;top:0;left:0">';
                foreach($users as $user){
                    $output .= '<li class="search_li"><a href="/profile/'.$user->id.'" style="display:block;">'.$user->name.'</li>';
                }
                $output .= '</ul>';
            }
            echo $output;
        }
    }
}
