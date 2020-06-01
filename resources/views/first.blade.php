@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @auth
            <div class="card">
              <div>
                  <table style="width:100%">
                    <ul class='response'>

                    </ul>
                      <tr>
                        <td style="text-align:center; width:25%;padding: 10px">Title</td>
                        <td style="width:75%;"><input type="text" name="title" size= "60" autoComplete="Off" placeholder="請輸入標題"></td>
                      </tr>
                      <tr>
                        <td style="text-align:center">Content</td>
                        <td><textarea name="content" cols="60" rows="7" style="resize:none" placeholder="請輸入內容"></textarea></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:right">
                          <button id="send_btn">送出</button>
                        </td>
                      </tr>
                  </table>

              </div>
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
            @else
            <div class="content">
                <div class="title m-b-md">
                    BLOG
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>

@endsection
