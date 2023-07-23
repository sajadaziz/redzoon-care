@extends('layouts.admin')
@section('content')
<div class="module">
  <div class="module-head">
        <h3>Bank Accounts</h3>
  </div>
  <div class="module-body">
      <ul class="unstyled">
          @foreach($listofaccounts as $list)
          <li><a href="{{route('accountDetail',$list->acid)}}">
                  <h3>{{$list->title}}&nbsp;&nbsp<small>(Account No: {{$list->actno}})</small></h3>
                  
              </a></li>
          @endforeach
      </ul>  
      
     
  </div>
    
</div>

@endsection