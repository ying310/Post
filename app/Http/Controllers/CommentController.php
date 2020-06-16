<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
     public function store(Request $request, $id){
        if($request->ajax()){
            $request->validate([
                'comment' => 'required|max:255',
            ]);
            $content = $request->input('comment');
            $comment = Comment::create([
                'user_id' => auth()->id(),
                'post_id' => $id,
                'content' => $content,
            ]);
        }
     }

     public function show(Request $request, $id){
        if($request->ajax()){
            $comments = Comment::with('user:id,name')->where('post_id', $id)->get();
            if($comments->isEmpty()){
                echo '<diiv style="color:#333;">沒有留言</div>';
            }else{
                foreach($comments as $comment){
                    echo '<div><a href="/profile/'. $comment->user->id . '">'. $comment->user->name . '</a>'
                          . '<span style="margin-left: 50px">' . $comment->content . '</span>'
                          . '<span style="float:right">' . $comment->updated_at->diffForHumans() . '</span></div><br>';
                }
            }

        }
     }
}
