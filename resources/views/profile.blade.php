@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div>個人資料
                      @if(auth()->id() != $user->id)
                      @can('viewAny', $user)
                      <button class="follow_btn" style="float:right; background: lightgreen; border:none; border-radius: 10px;color:white; outline-style:none" value=-1>已追蹤</button>
                      @elsecan('view', $user)
                      <button class="follow_btn" style="float:right; background: orange; border:none; border-radius: 10px;color:white; outline-style:none" value=0>等待確認</button>
                      @endcan
                      @cannot('viewAny', $user)
                      <button class="follow_btn" style="float:right; background: dodgerblue; border:none; border-radius: 10px;color:white; outline-style:none" value=1>追蹤對方</button>
                      @endcannot
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
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center">{{count($posts)}}</td>
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center">{{count($following)}}</td>
                          <td  style="font-size: 30px; padding:5px; width: 120px;text-align:center">{{count($follow_by)}}</td>
                        </tr>
                      </table>
                  </div>
                </div>
                <div class="card-header">文章</div>
                @can('viewAny', $user)
                <div class="card-body">
                    @forelse($posts as $post)
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
                  <h3 style="text-align:center; padding:30px">為私人帳號</h3>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $.ajaxSetup({
        'headers':{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
</script>
@endsection
