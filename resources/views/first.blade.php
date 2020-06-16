@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
          @auth
            <div class="card">
              <div class="card-header">
                <form action="{{route('search')}}" method="get">
                  <input type="text" name="search" autocomplete="off" style="border: 1px solid lightblue; border-radius: 20px;outline-style: none ;padding:5px 5px 5px 20px; width:200px" placeholder="搜尋">
                  <input type="submit" name="submit" value="搜尋" style="border:none; border-radius: 10px; background-color: lightblue; color: white">
                  <div id="nameList" style="position:relative;width:200px"></div>
                  @if($errors->first('search'))
                    <div style="color: red">{{$errors->first('search')}}</div>
                  @endif
                </form>
              </div>
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
                    <!-- @forelse($posts as $post)
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
                      <div class="like_count{{$post->id}}">讚{{$post->like_count}}</div>
                      <br>
                      @if(count($post->like) == 0)
                        <button class="like btn btn-warning" id="like_{{$post->id}}" value="0" data-post="{{$post->id}}">讚</button>
                      @else
                        <button class="like btn btn-success" id="like_{{$post->id}}" value="1" data-post="{{$post->id}}">收回</button>
                      @endif
                    </div>
                    <br>
                    @empty
                      <div>沒有文章</div>
                    @endforelse -->
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
    getPost();
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
                getPost();
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
function getPost(){
    $.ajax({
        url: '/post',
        type: "GET",
        success: function(data){
            $('.card-body').html(data);
        }
    });
}
$(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).on('click', '.like', function(){
      val = $(this).val();
      post = $(this).data('post');
      $.ajax({
          url: "{{route('like')}}",
          type: "POST",
          data: { val: val, post: post },
          success: function(data){
              // if(val == 0){
              //   $('#like_'+post).html('收回');
              //   $('#like_'+post).attr('class', 'like btn btn-success');
              //   $('#like_'+post).val(1);
              // }else if(val ==1){
              //   $('#like_'+post).html('讚');
              //   $('#like_'+post).attr('class', 'like btn btn-warning');
              //   $('#like_'+post).val(0);
              // }
              // $('.like_count'+post).html('讚'+data);
              getPost();
          },
      });
  });
  $('input[name="search"]').blur(function(){
      $('#nameList').fadeOut();
  });
  $('input[name="search"]').keyup(function(){
      if($(this).val() != ''){
         let search = $(this).val();
         $.ajax({
            url: "{{route('nameComplete')}}",
            type: "POST",
            data: {search : search},
            success: function(data){
                $('#nameList').html(data);
                $('#nameList').fadeIn();
            }
         });
      }else{
          $('#nameList').fadeOut();
      }
  });

  $(document).on('click', '.search_li', function(){
      $('input[name="search"]').val($(this).text());
      $('#nameList').fadeOut();
  });
});
</script>
@endsection
