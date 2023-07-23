@extends('layouts.admin')
@section('content')
<div class="module">
  <div class="module-head">
    <h3>Donee</h3>
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
     <form class="form-horizontal row-fluid" method="POST" enctype="multipart/form-data" action="{{route('Rt7AddDonee')}}">
         @csrf
         <!--**********************************************-->
	<div class="control-group">
	    <label class="control-label" for="name">{{__('Name:')}}</label>
	    <div class="controls">
		<div class="input-prepend">
		   <span class="add-on">First</span><input class="span3 form-control @error('txtFname') is-invalid @enderror" value="{{ old('txtFname') }}" required autocomplete="txtFname" autofocus type="text" name="txtFname" id ='txtFname' placeholder="sajad">  
                   <span class="add-on">Mid</span><input class="span3 form-control @error('txtMname') is-invalid @enderror" value="{{ old('txtMname') }}" required autocomplete="txtMname" autofocus type="text" name="txtMname" id='txtMname' placeholder="aziz">     
		   <span class="add-on">Last</span><input class="span3 form-control @error('txtLname') is-invalid @enderror" value="{{ old('txtLname') }}" required autocomplete="txtFname" autofocus type="text" name="txtLname" id='txtLname' placeholder="wani">     
		
                </div>
	    </div>
	</div>
         <!--**********************************************-->  
          <div class="control-group">
	    <label class="control-label">Gender</label>
		<div class="controls">
		   <label class="radio inline">
		    <input type="radio" name="gender" id="optG" value="M" checked="">
		    Male
		   </label> 
		  <label class="radio inline">
		   <input type="radio" name="gender" id="optG" value="F">
		    Female
		  </label> 
                    <span class="label inline"><b>Marital Status </b></span> 
                <label class="radio inline">
                    <input type="radio" name="mstatus" id="optMS" value="M" checked="">
		Married
		</label>
                    <label class="radio inline">
		<input type="radio" name="mstatus" id="optMS" value="N">
		Non-Married
		</label>
	      </div>
            
	      </div>
	
         <!--**********************************************88-->
        <div class="control-group">
	    <label class="control-label" for="phone">{{__('Phone') }}</label>
	    <div class="controls">
		<div class="input-prepend">
		   <span class="add-on">Mobile</span><input class="span4 form-control @error('txtMobile') is-invalid @enderror" value="{{ old('txtMobile') }}" required autocomplete="txtMobile" autofocus type="text" name="txtMobile" id ='txtMobile' placeholder="9906662310">  
                   <span class="add-on">Land Line</span><input class="span4" type="text" name="txtLandline" id='txtTo' placeholder="01942436300">     
                </div>
	    </div>
	</div>
         
        <!--/***********************************************-->
        <div class="control-group">
	 <label class="control-label" for="email">email</label>
	   <div class="controls">
		<input type="email" id="txtemail" name='txtemail' placeholder="support@redzoon.com" class="span8">
	    </div>
	 </div>
	<div class="control-group">
	 <label class="control-label" for="address">Address</label>
	     <div class="controls">
		<textarea class="span8"name='txtAddress'id='txtAddress' rows="5"></textarea>
	     </div>
        </div><br>	
        <!--***************************************************-->
        <div class="control-group">
	    <label class="control-label" for="basicinput">Donee Type</label>
	    <div class="controls">
		<select tabindex="1" data-placeholder="Donee Type" class="span4" id = "optDoneeType" name="optDoneeType">
                 @foreach($doneetype as $doneetype)  
                    <option value="{{$doneetype->shortname}}">{{$doneetype->optionname}}</option>
                 @endforeach
		</select>
                <span class='inline'>Since
                    <input class="span4" value="dd-mm-yyyy {{old('dpSince')}}"  type="text" id="dpSince" name="dpSince"> <span class='help-inline'>dd-mm-yyyy</span>
                </span>
	    </div>
           
	    
	</div>	
        <!--*****************************************************-->
        <div class="control-group">
	    <label class="control-label" for="basicinput">Status</label>
	    <div class="controls">
		<select tabindex="1" data-placeholder="Donee Type" class="span4" id = "optStatus" name="optStatus">
		   @foreach ($doneestatus as $status)
                    <option value="{{$status->shortname}}">{{$status->optionname}}</option>
                   @endforeach
		</select>
                <span class='inline'>District
                    <select tabindex="1" data-placeholder="District" class="span4" id = "optDistrict" name="optDistrict">
		    <option value="0">--Select District-</option>
                     @foreach($dbDistrict as $district) 
                     <option value='{{$district->did}}'>{{$district->fullname}}</option>
                     @endforeach 
                    </select>
                </span>
	    </div>
           
	    
	</div>	
        <!--*************************photo uploading unit **********************-->
        <div class="control-group" >
              <label class="control-label" for="doneePic">Upload Pic:</label>
	    <div class="controls">      
                <input class="span4" type="file" id="doneePic" name="doneePic">
               
            </div></div>
        <!--*****************************************************-->
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
<!-- javascript call for datepicker -->
<script type="text/javascript">
   
        $("#dpSince").datepicker({
  dateFormat: 'dd-mm-yy', //check change
  changeMonth: true,
  changeYear: true
});
        
           
        
    </script>

@endsection