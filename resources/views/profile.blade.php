@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(auth()->id() == $user->id)
                  @if(count($follows) > 0)
                    <div class="card-header">
                        <a href="javascript:void(replyFollow())">有人想追蹤你</a>
                    </div>
                    <div id="dialog_reply">
                        <div id="reply_content">

                        </div>
                    </div>
                  @endif
                @endif
                <div class="card-header">
                    <div>個人資料
                      @if(auth()->id() != $user->id)
                      @if(Auth::user()->can('viewAny', $user))
                      <button class="follow_btn" style="float:right; background: lightgreen; border:none; border-radius: 10px;color:white; outline-style:none" value=-1>已追蹤</button>
                      @elseif(Auth::user()->can('view', $user))
                      <button class="follow_btn" style="float:right; background: orange; border:none; border-radius: 10px;color:white; outline-style:none" value=-1>等待確認</button>
                      @else
                      <button class="follow_btn" style="float:right; background: dodgerblue; border:none; border-radius: 10px;color:white; outline-style:none" value=1>追蹤對方</button>
                      @endif
                      @endif
                    </div>
                </div>
                <div class="card-body">
                  <div style="float: left; width: 50%">
                    <table>
                        <tr>
                            <th style="width: 50px;padding: 10px">姓名</th>
                            <td style="padding: 15px">{{$user->name}}</td>
                        </tr>
                        <tr>
                            <th style="width: 50px;padding:10px">email</th>
                            <td style="padding: 15px">{{$user->email}}</td>
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
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center">{{count($user->post)}}</td>
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center"><a href="javascript:void({{$user->follows_count==0 ? 0 : 'getFollow(1)'}})" style="@if($user->follows_count == 0)cursor: default; color:black; text-decoration:none @endif">{{$user->follows_count}}</a></td>
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center"><a href="javascript:void({{$user->follow_by_count==0 ? 0 : 'getFollow(-1)'}})" style="@if($user->follow_by_count == 0)cursor: default; color:black; text-decoration:none @endif">{{$user->follow_by_count}}</a></td>
                        </tr>
                      </table>
                  </div>
                </div>
                <div class="card-header">文章</div>
                @can('viewAny', $user)
                <div class="card-body">
                    @forelse($user->post as $post)
                      <div style="border-bottom: 1px solid lightblue; margin: 10px; padding: 14px 16px">
                        @can('update', $post)
                        <div style="float:right">
                            <a href="/post/{{$post->id}}/edit">編輯</a>
                        </div>
                        @endcan
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
                      <h3 style="text-align:center;padding:5px">沒有文章</h3>
                    @endforelse
                </div>
                @else
                <div class="card-body">
                  <h3 style="text-align:center; padding:5px">為私人帳號</h3>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<div id="dialog_get">
  <div id="get_content">
  </div>
</div>
<script>

$(function(){
    $.ajaxSetup({
       'headers':{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#dialog_reply").dialog({
        autoOpen: false,
        draggable: false,
        modal: true,
        closeOnEscape:false,
        open:function(event,ui){$('.ui-dialog-titlebar-close').hide();},
        buttons: {
          'close': function(){ $(this).dialog('close');}
        }
    });

    $("#dialog_get").dialog({
      autoOpen:false,
      draggable: false,
      modal:true,
      closeOnEscape:false,
      open:function(event,ui){$('.ui-dialog-titlebar-close').hide();},
      buttons: {
        'close': function(){ $(this).dialog('close');}
      }
    });

    $('.follow_btn').click(function(){
      $.ajax({
          url: "{{route('follow', $user->id)}}",
          type: "POST",
          data: {follow_value: $('.follow_btn').val()},
          success: function(data){
              if(data == 0){
                  $('.follow_btn').html('等待確認');
                  $('.follow_btn').css('background', 'orange');
                  $('.follow_btn').val(-1);
              }else if(data == 1){
                  $('.follow_btn').html('追蹤對方');
                  $('.follow_btn').css('background', '#00bfff');
                  $('.follow_btn').val(1);
              }
          }
      });
    });
});
function getFollow(value){
   $(function(){
     let title = "追蹤";
     if(value == -1){
       title = "粉絲";
     }
     $('#dialog_get').dialog({title: title});
     $.ajaxSetup({
        'headers':{
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
     });
      $.ajax({
        url: "{{route('getFollow', $user->id)}}",
        type: "POST",
        data: {value:value},
        success: function(data){
            $('#get_content').html(data);
            $('#dialog_get').dialog('open');
        },
      });
   });
}

function replyFollow(){
    $(function(){
      $.ajaxSetup({
         'headers':{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
        $.ajax({
            url: "{{route('replyFollow')}}",
            type: "POST",
            success: function(data){
                var str = "<table style='width: 100%; background-color: #33d48c;'>";
                for(var i = 0 ; i < data.length; i++){
                  str += "<tr id='follow_" + data[i].user.id + "'" + "style='border: 1px solid lightblue'><td style='width: 50%; padding: 15px'>" + data[i].user.name + "</td><td><a href='javascript:void(allowFollow("+ data[i].user.id +"))' style='color: green'>V</a></td><td><a href='javascript:void(rejectFollow("+ data[i].user.id +"))' style='color: red'>X</a></td></tr>";
                }
                str += "</table>";
                $('#reply_content').html(str);
                $('#dialog_reply').dialog('open');
            }
        });
    });
}

function allowFollow(user){
    $(function(){
        str = "你已經同意";
        $.ajaxSetup({
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('allowFollow')}}",
            type: "POST",
            data: {user: user},
            success: function(data){
                $("#follow_"+user).html(str);
            }
        });
    });
}

</script>

@endsection
