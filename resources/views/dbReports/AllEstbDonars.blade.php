@extends('layouts.admin')
@section('content')
<div class="module">
  <div class="module-head">
        <h3>Donars Report of {{$fy}}</h3>
  </div>
  <div class="module-body">
      <ul class="unstyled">
          @foreach($estbBook as $list)
          <li><a href="{{route('estbbook',$list->shortname)}}">
                  <h3>{{$list->optionname}}&nbsp;&nbsp;<span class="badge">{{$list->TotalDonars}}</span></h3>
              </a></li>
          @endforeach
      </ul>  
      
     
  </div>
    
</div>

@endsection