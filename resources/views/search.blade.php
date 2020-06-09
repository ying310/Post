@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <form action="{{route('search')}}" method="get">
                  <input type="text" name="search" autocomplete="off" style="border: 1px solid lightblue; border-radius: 20px;outline-style: none ;padding:5px 5px 5px 20px" placeholder="搜尋">
                  <input type="submit" name="submit" value="搜尋" style="border:none; border-radius: 10px; background-color: lightblue; color: white">
                  @if($errors->first('search'))
                    <div style="color: red">搜尋不能空白</div>
                  @endif
                </form>
              </div>
                <div class="card-body">
                    @forelse($users as $user)
                    <div style="margin: auto; text-align:center; padding: 15px">
                      <a href="{{route('profile', $user->id)}}" style="font-size: 24px">{{$user->name}}</a>
                      <hr>
                    </div>
                    @empty
                      <div>沒有結果</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
