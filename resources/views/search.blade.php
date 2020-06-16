@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
<script>
$(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
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
