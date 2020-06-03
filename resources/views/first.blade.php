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
                        <td style="width:75%;"><input id="create_title" type="text" name="title" size= "60" autoComplete="Off" placeholder="請輸入標題"></td>
                      </tr>
                      <tr>
                        <td style="text-align:center">Content</td>
                        <td><textarea id="create_content" name="content" cols="60" rows="7" style="resize:none" placeholder="請輸入內容"></textarea></td>
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
                      <div style="float:right">
                          <h5><a href="/profile/{{$post->user_id}}">{{$post->user->name}}</a></h5>
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
<script>

$(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $("#send_btn").click(function(){
        $.ajax({
            url: "/post",
            type: "POST",
            data: {title: $('input[name="title"]').val(), content: $('textarea[name="content"]').val()},
            success: function(data){
                $('.response').html('');
                $('.response').append('<li style="color:red">Success</li>');
                $('.card-body').prepend('<div style="border-bottom: 1px solid lightblue; margin: 10px; padding: 14px 16px"><div><h3>' + data.title + '</h3></div><br>' +
                    '<div><p>' + data.content + '</p></div>'
                );
                $('#create_title').val('');
                $('#create_content').val('');
            },
            error: function(xhr){
                if(xhr.status == 422){
                        $('.response').html('');
                    $.each(xhr.responseJSON.errors, function(key, value){

                        $('.response').append('<li style="color: red">'+value+'</li>');
                    });
                }
            }
        });
    });
});
</script>
@endsection
