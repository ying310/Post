@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div style="margin: 10px; padding: 14px 16px">
                      <div>
                        <form action="/post/{{$post->id}}" method="post">
                          @method('PUT')
                          @csrf
                          <table style="width:100%">
                            <ul class='response'>

                            </ul>
                              <tr>
                                <td style="text-align:center; width:25%;padding: 10px">Title</td>
                                <td style="width:75%;"><input type="text" name="title" size= "60" autoComplete="Off" placeholder="請輸入標題" value="{{$post->title}}"></td>
                              </tr>
                              <tr>
                                <td style="text-align:center">Content</td>
                                <td><textarea name="content" cols="60" rows="7" style="resize:none" placeholder="請輸入內容" value="{{$post->content}}">{{$post->content}}</textarea></td>
                              </tr>
                              <tr>
                                <td colspan="2" style="text-align:right">
                                  <button type="submit">送出</button>
                                  </form>
                                  <form action="/post/{{$post->id}}" method="post" style="float:left">
                                    @csrf
                                    @method('DELETE')
                                    <button>刪除</button>
                                  </form>
                                </td>
                              </tr>
                          </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
