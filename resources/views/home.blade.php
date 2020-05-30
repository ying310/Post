@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">文章</div>

                <div class="card-body">
                    @forelse($posts as $post)
                      <div>$post->title</div>
                      <div>$post->content</div>
                    @empty
                      <div>沒有文章</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
