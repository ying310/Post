@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">個人資料</div>
                <div class="card-body">
                  <div style="float: left; width: 50%">
                    <table>
                        <tr>
                            <th style="width: 50px;padding: 10px">姓名</th>
                            <td style="padding: 15px">{{auth()->user()->name}}</td>
                        </tr>
                        <tr>
                            <th style="width: 50px;padding:10px">email</th>
                            <td style="padding: 15px">{{auth()->user()->email}}</td>
                        </tr>
                    </table>
                  </div>
                  <div style="float:left; width: 50%">
                      <table>
                        <tr>
                          <th style="font-size: 30px; padding:5px; width: 120px;text-align:center">文章</th>
                          <th style="font-size: 30px; padding:5px; width: 120px;text-align:center">追隨</th>
                          <th style="font-size: 30px; padding:5px; width: 120px;text-align:center">粉絲</th>
                        </tr>
                        <tr>
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center">10</td>
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center">5</td>
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center">5</td>
                        </tr>
                      </table>
                  </div>
                </div>
                <div class="card-header">文章</div>

                <div class="card-body">
                    @forelse($posts as $post)
                      <div style="border-bottom: 1px solid lightblue; margin: 10px; padding: 14px 16px">
                        <div style="float:right">
                            <a href="/post/{{$post->id}}/edit">編輯</a>
                        </div>
                        <div>
                          <h3><a href="/post/{{$post->id}}">{{$post->title}}</a></h3>
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
