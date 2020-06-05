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

    public function getFollow(Request $request, $id){
        if($request->ajax()){
            $input = $request->input('value');
            if($input == 1){
                $follows = Follow::with('follow_user')->where('user_id', $id)->where('is_check', 1)->get();
                $output = "<table>";
                foreach($follows as $follow){
                    $output = $output . "<tr><td><a href='/profile/".$follow->follow_user->id."'>" . $follow->follow_user->name . "</a></td></tr>";
                }
                $output = $output . "</table>";
                echo $output;
            }elseif($input == -1){
                $follows = Follow::with('user')->where('following_user_id', $id)->where('is_check', 1)->get();
                $output = "<table>";
                foreach($follows as $follow){
                    $output = $output . "<tr><td><a href='/profile/".$follow->user->id."'>" . $follow->user->name . "</a></td></tr>";
                }
                $output = $output . "</table>";
                echo $output;
            }

        }
    }
}
