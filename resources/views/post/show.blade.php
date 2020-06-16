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
                        <br>
                      @endcan
                      <div style="margin-bottom: 15px">
                          <h3 style="float:right"><a href="/profile/{{$post->user->id}}">{{$post->user->name}}</a></h3>
                          <h1 style="margin-left: 15px">{{$post->title}}</h1>
                      </div>
                      <br>
                      <div>
                          <p style="margin-left: 15px; font-size: 30px">{{$post->content}}</p>
                      </div>
                    </div>
                    <div id="likeInformation">
                </div>


                </div>
            </div>
            <div class="card" style="font-size: 20px;text-align:center">
              留言區
              <div class="card-body comment" style="text-align:left">

              </div>
              <textarea style="resize:none;" placeholder="請輸入留言.." name="comment"></textarea>
              <span style="text-align:left; font-size: 15px; color:red" id="error_comment"></span>
              <button class="btn btn-success" type="button" id="btn_comment">送出</button>
            </div>

        </div>
    </div>
</div>

<div id="like_dialog" title="有誰按讚">
</div>

<script>
$(function(){
    $.ajaxSetup({
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#like_dialog').dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        closeOnEscape:false,
        open:function(event,ui){$('.ui-dialog-titlebar-close').hide();},
        buttons: {
          '關閉': function(){ $(this).dialog('close'); }
        }
    });
    getComment();
    likeInformation();


    $('#btn_comment').click(function(e){
        e.preventDefault();
        let comment = $('textarea[name="comment"]').val();
        $.ajax({
            url: "{{route('comment.store', $post->id)}}",
            type: "POST",
            data: {comment : comment},
            success: function(){
                $('#error_comment').html('');
                $('textarea[name="comment"]').css('border','');
                $('textarea[name="comment"]').val('');
                getComment();
            },
            error: function(xhr){
                $('#error_comment').html(xhr.responseJSON.errors.comment[0]);
                $('textarea[name="comment"]').css('border','1px solid red');
            }
        });
    })
    function getComment(){
      $.ajax({
          url: "{{route('comment.show', $post->id)}}",
          type: "GET",
          success: function(data){
              $('.comment').html(data);
          },
      });
    }

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
                likeInformation();
            },
        });
    });
    function likeInformation(){
        $.ajax({
            url: "{{route('like.information',$post->id)}}",
            type: "POST",
            success: function(data){
                $('#likeInformation').html(data);
            }
        });
    }


});
function likeShow(){
    $.ajax({
        url: "{{route('like.show', $post->id)}}",
        type: "GET",
        success: function(data){
            $('#like_dialog').html(data);
            $('#like_dialog').dialog('open');
        }
    });
}

</script>
@endsection
