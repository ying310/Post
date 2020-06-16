<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Follow;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $user = User::where('id', auth()->id())->first();
            $follow = $user->follows->pluck('id');
            $follow = $follow->push(auth()->id());
            $posts = Post::with(['user:id,name', 'like'=> function($query){ $query->where('user_id', auth()->id())->where('type', 1); }])
            ->withCount(['like' => function($query){ $query->where('type', 1); }, 'comment'])
            ->whereIn('user_id', $follow)->latest()->get();
            foreach($posts as $post){
              echo '<div style="border-bottom: 1px solid lightblue; margin: 10px; padding: 14px 16px">
                <div style="float:right">
                    <h5><a href="/profile/'. $post->user_id . '">' . $post->user->name . '</a></h5>
                </div>
                <div>
                    <h2 style="padding:10px"><a href="/post/' . $post->id . '">' . $post->title . '</a></h2>
                </div>
                <br>
                <div>
                    <p style="font-size: 30px; padding:10px">' . $post->content . '</p>
                </div>
                <div>
                <span class="like_count' . $post->id . '">讚' . $post->like_count . '</span>
                <span class="comment_count'.$post->id. '" style="margin-left: 10px">留言'.$post->comment_count. '</span>
                <span style="float:right">'.$post->updated_at->diffForHumans().'</span>
                </div>
                <br>';
                if(count($post->like) == 0){
                  echo '<button class="like btn btn-warning" id="like_'.$post->id.'" value="0" data-post="'.$post->id.'">讚</button></div>';
                }
                else{
                  echo '<button class="like btn btn-success" id="like_'.$post->id.'" value="1" data-post="'.$post->id.'">收回</button></div>';
                }
            }
        }else{
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          if($request->ajax()){
              $request->validate([
                'title' => 'required|max:50',
                'content' => 'required|max:255',
              ],[
                'title.required' => '標題必須要填寫',
                'title.max' => '標題不能超過:max字',
                'content.required' => '內容不能空白',
                'content.max' => '內容不能超過:max字',
              ]);
              $input = $request->all();
              $user_id = auth()->id();
              $input['user_id'] = $user_id;
              $post = Post::create($input);
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user:id,name')->findOrFail($id);
        return view('post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if(auth()->user()->can('update', $post)){
          return view('post.edit', ['post' => $post]);
        }else{
          abort(403,'抱歉你沒有權限更改');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if(auth()->user()->can('update', $post)){
          $request->validate([
              'title' => 'required|max:50',
              'content' => 'required|max:255',
          ]);
          $post->update($request->all());
          return redirect('/post/'.$id);
        }else{
          return abort(403, '抱歉你沒有權限更改');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::findOrFail($id);
      if(auth()->user()->can('delete', $post)){
        $post->delete();
        return redirect('/');
      }
    }
}
