@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">文章</div>

                <div class="card-body">
                    @forelse($posts as $post)
                      <div style="border-bottom: 1px solid lightblue; margin: 10px; padding: 14px 16px">
                        <div>
                          <h3>{{$post->title}}</h3>
                        </div>
                        <br>
                        <div>
                          <p>{{$post->content}}</p>
                        </div>
                      </div>
                      <br>
                    @empty
                      <div>沒有文章</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
