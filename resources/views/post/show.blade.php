@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div style="margin: 10px; padding: 14px 16px">
                      @can('update', $post)
                        <div>
                          <a href="/post/{{$post->id}}/edit" style="float:right">編輯</a>
                        </div>
                      @endcan
                      <div style="margin-bottom: 15px">
                          <h5><a href="#">{{$post->user->name}}</a></h5>
                      </div>
                      <div>
                          <h3 style="margin-left: 15px">{{$post->title}}</h3>
                      </div>
                      <br>
                      <div>
                          <p style="margin-left: 15px">{{$post->content}}</p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
