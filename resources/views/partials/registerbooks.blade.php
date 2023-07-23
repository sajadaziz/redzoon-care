@extends('layouts.admin')
@section('content')
<div class="module">
  <div class="module-head">
    <h3>Register Reciept Books</h3>
  </div>
  <div class="module-body">
      @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
     @endif
       @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
@endif
     <form class="form-horizontal row-fluid" method="POST" action="{{route('Rt5Save')}}">
         {{ csrf_field() }}
         <!--**********************************************-->
        
	<div class="control-group">
	    <label class="control-label" for="basicinput">Book No</label>
	    <div class="controls">
		<input type="text" id="txtBookNo" name="txtBookNo" placeholder="00001" class="span8">
		<span class="help-inline">Numeric only</span>
	    </div>
	</div>
         <!--**********************************************88-->
        <div class="control-group">
	    <label class="control-label" for="basicinput">Reciept Book No'</label>
	    <div class="controls">
		<div class="input-prepend">
		   <span class="add-on">From</span><input class="span4" type="text" name="txtFrom" id ='txtFrom' placeholder="00001">  
                   <span class="add-on">To</span><input class="span4" type="text" name="txtTo" id='txtTo' placeholder="00050">     
		</div>
	    </div>
	</div>
         
        <!--/***********************************************-->
	<div class="control-group">
	    <label class="control-label" for="basicinput">Book weight</label>
	    <div class="controls">
                <div class='input-prepend'>
                    <span class="add-on">No of Leaves</span><input type="text" id="txtNol" name="txtNol" placeholder="50" class="span2">
                    <span class="add-on">Book Type</span><select tabindex="1" data-placeholder="Select here.." class="span5" id = "optBookMode" name="optBookMode">
		    @foreach($estbBooks as $options)
                        <option value="{{$options->shortname}}">{{$options->optionname}}</option>
                   @endforeach
		    
		</select>
                </div>
	    </div>
	</div>									
	<div class="control-group">
	    <div class="controls">
        	<button type="submit" class="btn">Save</button>
                <a href="{{route('home')}}" class="menu-icon">Cancel</a>
	    </div>
	</div>
    </form>
  </div>
    <br><br><br><br><br><br><br>
</div>
<script type='text/javascript'>

 jQuery("#txtTo").blur(function() {
         var valT = $('#txtTo').val();
         var valF = $('#txtFrom').val();
	$("#txtNol").val(Number(valT)-Number(valF)+1);
    });
     </script>
@endsection