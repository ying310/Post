<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follow;

class FollowController extends Controller
{
    public function follow(Request $request, $id){
        if($request->ajax()){
            if($request->input('follow_value') == 1){
                $follow = Follow::create([
                  'user_id' => auth()->id(),
                  'following_user_id' => $id,
                ]);
                return 0;
            }
            if($request->input('follow_value') == -1){
                Follow::where('user_id', auth()->id())->where('following_user_id', $id)->delete();
                return 1;
            }
        }

    }
}
