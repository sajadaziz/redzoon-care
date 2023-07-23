@extends('layouts.admin')
@section('content')
 <!--/.span3-->
 
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-body">
                                 @if(session()->has('message'))
                                    <div class="alert alert-success" id="success-alert">
                                         {{ session()->get('message') }}
                                     </div>
                                @endif
                                <div class="profile-head media">
                                    <a href="#" class="media-avatar pull-left">
                                   <img src="{{ asset('images/app-img/').'/'.$doneepic }}" class="nav-avatar" /> 
                                    </a>
                         
                                    <div class="media-body">
                                        <h4>
                                            {{$fullname}} <small>({{$memtype}})</small>
                                        </h4>
                                        <p class="profile-brief">
                                        <ul>
                                            <li>Issued On : <mark><strong><em>{{$issuedon}}</em></strong></mark></li>
                                            <li> Status : <mark><strong><em>{{$status}}</em></strong></mark></li>                                           
                                            <li>No' of leaves used: <mark><strong><em>{{$nolused}}</em></strong></mark></li>
                                            <li>No' of leaves Unused:<mark><strong><em> {{$nolNused}}</em></strong></mark></li>
                                        </ul>
                                            
                                        </p>
                                        <div class="profile-details muted">
                                            <a href="{{ url('RecieveRBook',$assignID) }}" class="btn btn-info" id="linkA"><i class="icon-bookmark shaded"></i></a>
                                            <a href="{{ url ('CloseRBook',$rbid)}}" class="btn btn-warning" id ="linkR" onclick="return confirm('Are you sure, you want to close this book?After that you will not be able to insert data in this book')">
                                                <i class="icon-ban-circle shaded"></i></a>
                                        </div>
                                         
                                    </div>
                                </div><br>
                                
                                
                                
                                       <!-- Tab 1 starts from here--->
                                       <div class="module">
  <div class="module-head">
    <h3>Reciept Book No' {{$bookno}}-{{$bookmode}}</h3>
  </div>
  <div class="module-body">           
         <!--**********************************************88-->
         <table class="table table-striped table-bordered table-condensed">
								  <thead>
									<tr>
									  <th>Reciept No'</th>
                                                                          <th>Donar Name</th>
									  <th>Address</th>
									  <th>Phone</th>
                                                                          <th>Deposit</th>
                                                                          <th>Amount</th>
                                                                          <th></th>
									</tr>
								  </thead>
								  <tbody>
                                                                   @foreach($donarDetail as $Ddetail)
									<tr>
                                                                            @if($Rbstatus === 'C')
                                                                                <td>{{$Ddetail->drRno}}</td>
                                                                                <td>{{$Ddetail->drname}}</td>
                                                                                <td>{{$Ddetail->draddress}}</td>
                                                                                <td>{{$Ddetail->drmobile}}</td>
                                                                                @if ($Ddetail->drAmtype === 'CANCELLED')
                                                                                <td><mark><del>&#8377;{{$Ddetail->drAmount}}</del></mark></td>
                                                                                 <td><mark>{{$Ddetail->drAmtype}}</mark></td>
                                                                                 <td> <a href="{{url('CancelBookLeaf',$Ddetail->dr_id)}}" disabled='disabled' class="btn btn-warning" id ="linkR" onclick="return confirm('Are you sure, you want to Cancel  this book leaf? This is irreversible action')"><i class="icon-remove"></i></a></td>
                                                                                @else
                                                                                 <td>&#8377;{{$Ddetail->drAmount}}</td>
                                                                                 <td>{{$Ddetail->drAmtype}}</td>
                                                                                 <td> <a href="{{url('CancelBookLeaf',$Ddetail->dr_id)}}" disabled='disabled'class="btn btn-warning" id ="linkR" onclick="return confirm('Are you sure, you want to Cancel  this book leaf? This is irreversible action')"><i class="icon-remove"></i></a></td>
                                                                                @endif
                                                                             @else
                                                                                <td>{{$Ddetail->drRno}}</td>
                                                                                <td>{{$Ddetail->drname}}</td>
                                                                                <td>{{$Ddetail->draddress}}</td>
                                                                                <td>{{$Ddetail->drmobile}}</td>
                                                                                @if ($Ddetail->drAmtype === 'CANCELLED')
                                                                                <td><mark><del>&#8377;{{$Ddetail->drAmount}}</del></mark></td>
                                                                                 <td><mark>{{$Ddetail->drAmtype}}</mark></td>
                                                                                 <td> <a href="{{url('CancelBookLeaf',$Ddetail->dr_id)}}" disabled='disabled' class="btn btn-warning" id ="linkR" onclick="return confirm('Are you sure, you want to Cancel  this book leaf? This is irreversible action')"><i class="icon-remove"></i></a></td>
                                                                                @else
                                                                                 <td>&#8377;{{$Ddetail->drAmount}}</td>
                                                                                 <td>{{$Ddetail->drAmtype}}</td>
                                                                                 <td> <a href="{{url('CancelBookLeaf',$Ddetail->dr_id)}}" class="btn btn-warning" id ="linkR" onclick="return confirm('Are you sure, you want to Cancel  this book leaf? This is irreversible action')"><i class="icon-remove"></i></a></td>
                                                                                @endif
                                                                             @endif
                                                                        </tr>                                                     
                                                                  @endforeach
                                                                  </tbody>
         </table><br>
       
         
        <!--/***********************************************-->							
	<div class="control-group">
	    <div class="controls">
                @if($checkregistration==='0')
        	<a href="#" class="btn btn-info" id="btndownload" disabled='disabled'><i class="icon-download shaded"></i>Download Report in PDF format</a>
                <small class="alert alert-warning">Please Register to get download button enabled</small>
                @else
                <a href="{{route('pdf',$assignID)}}" class="btn btn-info" id="btndownload"><i class="icon-download shaded"></i>Download Report in PDF format</a>
                @endif
                <a href="{{route('home')}}" class="btn btn-warning">Cancel</a>
                <input type="hidden" id="_rbid" value="{{$Rbstatus}}">
                <input type="hidden" id="_abid" value="{{$Abstatus}}">
	    </div>
	</div>
   
  </div>
   
</div>

  
                                      
                                    
                                    
                                </div>
                            
                            <!--/.module-body-->
                        </div>
                        <!--/.module-->
                    </div>
                    <!--/.content-->
                </div>
  <script type='text/javascript'>
      $(document).ready(function(){
          CheckRegistration();
          var rbstatus = $("#_rbid").val();
          var abstatus = $("#_abid").val();
          
          if(rbstatus === "C") { 
              $("#linkR").attr('disabled',true);
              $("#linkR").append('Book Closed');
        
        } else {$("#linkR").attr('disabled',false);$("#linkR").append('Close book'); }
        
          if(abstatus === "R") {
              $("#linkA").attr('disabled',true);
              $("#linkA").append('Book Received');
          
        } else {$("#linkR").attr('disabled',false);$("#linkA").append('Collect Book'); }
          
          
              
      });
      $("#success-alert").ready(function(){
         $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);});

      });
      function CheckRegistration(){
         
       $.ajax({
         url: '',
         type: 'get',
         dataType: 'json',
         success: function(response){                
            if(response['data'] != null){
             $("#btndownload").prop('disabled',false);
             //$("#txtReg").prop('disabled',true);
             }
             else{
                 $("#btndownload").prop('disabled',true);
                // $("#txtReg").prop('disabled',false);
                 }

         }
       });
     }
     
  </script>
      
@endsection