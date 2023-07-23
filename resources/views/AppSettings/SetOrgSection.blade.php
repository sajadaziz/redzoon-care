@extends('layouts.admin')
@section('content')
 <!--/.span3-->
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-body">
                                <div class="profile-head media">
                                   
                                    <div class="media-body">
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
                                        <h4>
                                           Application Settings
                                        </h4>
                                        <p class="profile-brief">
                                           
                                        <!-- short descrioption -->
                                        </p>
                                        
                                    </div>
                                </div>
                                
                                <ul class="profile-tab nav nav-tabs">
                                    <li class="active"><a href="#add" data-toggle="tab">Establishment</a></li>
                                    <li><a href="#optionlabel" data-toggle="tab">Option Labels</a></li>
                                     <li><a href="#vaccant" data-toggle="tab">Bank linking</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="add">
                                       <!-- Tab 1 starts from here--->
                                       <div class="module">
  <div class="module-head">
    <h3>Registration</h3>
  </div>
  <div class="module-body">   
              <!--**********************************************88-->
         <form class="form-horizontal row-fluid" id='donarsform' name="Estbform" method="POST" enctype="multipart/form-data" action="{{route('appRegistration')}}">
         @csrf
         <!--**********************************************-->
	
          <!--/***********************************************-->
          <div class="control-group">
	    <label class="control-label" for="txtEstbName">Establishment Name:</label>
	    <div class="controls">      
                <input class="span8" type="text" id="txtEstbName" name="txtEstbName" required="" value="{{old('txtEstbName')}}">
               
            </div>	    
	</div>	
        <div class="control-group">
	    <label class="control-label" for="phone">{{__('Phone') }}</label>
	    <div class="controls">
		<div class="input-prepend">
		   <span class="add-on">Mobile</span><input class="span4 form-control @error('txtMobile') is-invalid @enderror" value="{{ old('txtMobile') }}" required autocomplete="txtMobile" autofocus type="text" name="txtMobile" id ='txtMobile' placeholder="9906662310">  
                   <span class="add-on">Land Line</span><input class="span4" type="text" name="txtLandline" id='txtLandline' placeholder="01942436300" value="">     
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
	 <label class="control-label" for="URL">Establishment Web Site</label>
	   <div class="controls">
               <input type="url" id="txturl" name='txturl' placeholder="http://www.redzoon.com" class="span8">
	    </div>
	 </div>
	<div class="control-group">
	 <label class="control-label" for="address">Address</label>
	     <div class="controls">
		<textarea class="span8"name='txtAddress'id='txtAddress' rows="5"></textarea>
	     </div>
        </div>	
          <!--/***********************************************-->
         <div class="control-group" >
              <label class="control-label" for="txtOptionShortName">Upload logo:</label>
	    <div class="controls">      
                <input class="span4" type="file" id="logoimage" name="logoimage">
               
            </div>	    
	</div>
  
	         
                  <!--**********************************************-->
                  
                  
          <div class="control-group">
              <label class="control-label">Registration Key :</label>
              <div class="controls">
                  <input type="text" class="span8" name='txtReg' id = "txtReg" ><span class="alert-info"><small>Free Version</small></span>
              </div>
          </div>
        
         
        <!--/***********************************************-->							
	<div class="control-group">
	    <div class="controls">
        	<button type="submit" class="btn btn-info" id="btnRegistration">Register Now!</button>
                <a href="{{route('home')}}" class="btn btn-warning">Later</a>
	    </div>
	</div>
    </form>
  </div>
   
</div>                                      
</div><!--add -->


<!-- Tab 2 starts from here option labels--->
 <div class="tab-pane fade" id="optionlabel">
        
     <div class="module">
  <div class="module-head">
    <h3>Add New</h3>
  </div>
  <div class="module-body">      
       <form class="form-horizontal row-fluid" method="POST" action="{{route('addoptions')}}">
         {{ csrf_field() }}
         <!--**********************************************-->
         <div class="control-group">
        <label class="control-label" for="optOptionType">Option Type</label>
	    <div class="controls">
                <select tabindex="1"  id = "optOptionType" name="optOptionType">
		    <option value="Designation">Designation</option>
                    <option value="Bank" selected="true">Bank</option>
                    <option value="BankAccount">Bank Account Purpose</option>
		    <option value="Donation">Donation</option>
                    <option value="DoneeType">Donee Type</option>
                    <option value="DoneeStatus">Donee Status</option>
                    <option value="EstbBook">Establishment Books </option>
		</select>
            </div>
         </div>
         <!--**********************************************88-->
        <div class="control-group">
	    <label class="control-label" for="txtOptionName">Option Name</label>
	    <div class="controls">
                <input class="span4" type="text" name="txtOptionName" id ='txtOptionName'required="">  
            </div>
	</div>
          <div class="control-group">
              <label class="control-label" for="txtOptionShortName">Option Short Name:</label>
	    <div class="controls">      
                <input class="span4" type="text" id="txtOptionShortName" name="txtOptionShortName" required=""><small>6 characters only</small>
               
            </div>	    
	</div>
            
        <!--/***********************************************-->
	
	    
	<div class="control-group">
	    <div class="controls">
        	<button type="submit" class="btn">Add</button>
                <a href="{{route('home')}}" class="menu-icon">Cancel</a>
	    </div>
	</div>
       </form><br>
   <div class="module-body table">
     <table id='user_table' class="span8 table table-bordered table-striped display-1">
	<thead>
	  <tr>
	    <th>S.no</th>
	    <th>Option Name</th>
            <th>Short Name </th>
            
	  </tr>
	</thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div><!--module body-->
 </div><!--module-->                                      
 </div><!-- option label--->
 <!-- Tab 2 ends from here option labels--->
<!-- Tab 2 starts from here option labels--->
 <div class="tab-pane fade" id="vaccant">
        
     <div class="module">
  <div class="module-head">
    <h3>Link</h3>
  </div>
  <div class="module-body">      
       <form class="form-horizontal row-fluid" method="POST" action="{{route('savebankaccount')}}">
         {{ csrf_field() }}
         <!--**********************************************-->
         <div class="control-group">
        <label class="control-label" for="optBankName">Bank Name</label>
	    <div class="controls">
                <select tabindex="1"  id = "optBankName" name="optBankName">
                    @foreach($optBankName as $data)
		    <option value="{{$data->id}}">{{$data->optionname}}</option>
                    @endforeach
                </select>
            </div>
         </div>
         <!--**********************************************88-->
        <div class="control-group">
	    <label class="control-label" for="txtAccountNo">16-Digit Account No</label>
	    <div class="controls">
                <input class="span4" type="text" name="txtAccountNo" id ='txtAccountNo'required="">  
            </div>
	</div>
          <div class="control-group">
              <label class="control-label" for="txtIfscCode">IFSC Code:</label>
	    <div class="controls">      
                <input class="span4" type="text" id="txtIfscCode" name="txtIfscCode">
               
            </div>	    
	</div>
         <div class="control-group">
              <label class="control-label" for="txtBranch">Branch:</label>
	    <div class="controls">      
                <input class="span4" type="text" id="txtBranch" name="txtBranch">
               
            </div>	    
	</div>
         <div class="control-group">
              <label class="control-label" for="txtAccountTitle">Account Title in the bank:</label>
	    <div class="controls">      
                <input class="span4" type="text" id="txtAccountTitle" name="txtAccountTitle">
               
            </div>	    
	</div>
          <div class="control-group">
        <label class="control-label" for="optAccountType">Account Type</label>
	    <div class="controls">
                <select tabindex="1"  id = "optAccountType" name="optAccountType">
		    <option value="CA">Current Account</option>
                    <option value="SA">Saving Account</option>
                </select>
            </div>
         </div>
         <div class="control-group">
        <label class="control-label" for="optAccountPurpose">Purpose of the Account</label>
	    <div class="controls">
                <select tabindex="1"  id = "optAccountPurpose" name="optAccountPurpose">
                    @foreach($optAccountPurpose as $data)
		    <option value="{{$data->id}}">{{$data->optionname}}</option>
                    @endforeach
                </select>
            </div>
         </div>
            <div class="control-group">
        <label class="control-label" for="optEstablishment">Link Establishment</label>
	    <div class="controls">
                <select tabindex="1"  id = "optEstablishment" name="optEstablishment">
		    @foreach($optEstbBook as $data)
		    <option value="{{$data->id}}">{{$data->optionname}}</option>
                    @endforeach
                    
                </select>
            </div>
         </div>
        <!--/***********************************************-->
	
	    
	<div class="control-group">
	    <div class="controls">
        	<button type="submit" class="btn">Add</button>
                <a href="{{route('home')}}" class="menu-icon">Cancel</a>
	    </div>
	</div>
       </form>
      
  </div><!--module body-->
 </div><!--module-->                                      
 </div><!-- option label--->
 <!-- Tab 2 ends from here option labels--->
     
   
                                </div><!--tab content -->
              
                            </div>
                            <!--/.module-body-->
                        </div>
                        <!--/.module-->
                    </div>
                    <!--/.content-->
                </div>

<script type = 'text/javascript'>
    $("#optOptionType").change(function(){
       var type = $("#optOptionType").val(); 
       fetchRecords(type);
    });
     $(document).ready(function () {
        CheckRegistration();
    });
  function fetchRecords(type){
         
       $.ajax({
         url: 'getOption/'+type,
         type: 'get',
         dataType: 'json',
         success: function(response){                
            if(response['data'] != null){
             $('#user_table tbody').empty();
            var len = response['data'].length;
            for(var i=0; i<len; i++){
              var tr_str = "<tr><td>"+(i+1)+"</td><td>"+
                  response['data'][i].optionname  +"</td><td>"+ response['data'][i].shortname +"</td>"+
              "</tr>";
                $("#user_table tbody").append(tr_str);
            }
              //$("#lblDonee").append(tr_str);
           }else{
               $("#lblDonee").empty();
                $("#lblDonee").show();
                 $("#submit").prop('disabled',true);
              var tr_str = "<div class='alert alert-danger'><b> No record found</b></div>";
              $("#lblDonee").append(tr_str);
           }

         }
       });
     }
     function CheckRegistration(){
         
       $.ajax({
         url: 'checkRegistration',
         type: 'get',
         dataType: 'json',
         success: function(response){                
            if(response['data'] != null){
             $("#btnRegistration").prop('disabled',true);
             $("#txtReg").prop('disabled',true);
             }
             else{
                 $("#btnRegistration").prop('disabled',false);
                 $("#txtReg").prop('disabled',false);
                 }

         }
       });
     }
     </script>
     
@endsection