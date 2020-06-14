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
            $like = Like::where('post_id', $post_id)->where('type',1)->count();
            echo $like;
        }
    }
}
