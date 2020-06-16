<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
class LikeController extends Controller
{
    public function like(Request $request){
        if($request->ajax()){
            $val = $request->input('val');
            $post_id = $request->input('post');
            $like = Like::where('user_id', auth()->id())->where('post_id', $post_id)->first();
            if($val == 0){
                if($like){
                    $like->type = 1;
                    $like->save();
                }else{
                    $like = Like::create([
                        'user_id' => auth()->id(),
                        'post_id' => $post_id,
                        'type' => 1
                    ]);
                }
            }elseif($val == 1){
                $like->type = 0;
                $like->save();
            }
        }
    }

    public function likeInformation(Request $request, $id){
        if($request->ajax()){
            $like = Like::where('user_id', auth()->id())
                          ->where('post_id', $id)->where('type', 1)->first();
            $count = Like::where('post_id', $id)->where('type', 1)->count();
            if($count == 0){
                echo '<div><a href="javascript:void(0)"style="font-size:15px; cursor: default; color:black; text-decoration:none" >讚'.$count.'</a></div><br>';
            }else{
                echo '<div><a href="javascript:void(likeShow())"style="font-size:15px" >讚'.$count.'</a></div><br>';
            }
            if($like){
                echo '<button class="like btn btn-success" id="like_'.$id.'" value="1" data-post="'.$id.'">收回</button></div>';
            }else{
                echo '<button class="like btn btn-warning" id="like_'.$id.'" value="0" data-post="'.$id.'">讚</button></div>';
            }

        }
    }

    public function show(Request $request, $id){
        if($request->ajax()){
            $likes = Like::with('user:id,name')->where('post_id', $id)->where('type', 1)->get();
            if($likes->isEmpty()){
                $output = '沒有人按讚';
            }else{
                $output = '<ul style="type:none">';
                foreach($likes as $like){
                    $output .= "<li><a href='/profile/".$like->user->id."'>".$like->user->name."</a></li>";
                }
                $output .= "</ul>";
            }
            echo $output;
        }
    }
}
