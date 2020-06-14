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
            $user = User::find(auth()->id());
            $follow = $user->follow->pluck('id');
            $follow = $follow->push(auth()->id());
            $posts = Post::withCount(['like' => function($query){ $query->where('type', 1); }])where('user_id', $follow)->get();
            foreach($posts as $post){
              echo '<div style="border-bottom: 1px solid lightblue; margin: 10px; padding: 14px 16px">
                <div style="float:right">
                    <h5><a href="/profile/'. $post->user_id . '">' . $post->user->name . '</a></h5>
                </div>
                <div>
                    <h3><a href="/post/' . $post->id . '">' . $post->title . '</a></h3>
                </div>
                <br>
                <div>
                    <p>' . $post->content . '</p>
                </div>
                <div class="like_count' . $post->id . '">讚' . $post->like_count . '</div>
                <br>
              </div>';
            }
        }
        return redirect('/');
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
              ]);
              $input = $request->all();
              $user_id = auth()->id();
              $input['user_id'] = $user_id;
              $post = Post::create($input);
              return $post;
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
