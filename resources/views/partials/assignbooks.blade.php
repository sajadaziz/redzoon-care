@extends('layouts.admin')
@section('content')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<div class="module">
  <div class="module-head">
    <h3>Assign Reciept Books</h3>
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
     <form class="form-horizontal row-fluid" method="POST" action="{{route('Rtsave-assign-book')}}">
         {{ csrf_field() }}
         <!--**********************************************-->
         <div class="control-group">
	    <label class="control-label" for="selectreciptbook">Select Reciept Book</label>
	    <div class="controls">
		<select tabindex="1" data-placeholder="Select here.." class="span8" id = "optRbook" name="optRbook">
		    <option value="0">Select</option>
                    @foreach($dbAssignBooks as $assignbooks) 
                     <option value='{{$assignbooks->id}}'>{{$assignbooks->book_no.'-'.$assignbooks->bookmode}}</option>
                     @endforeach 
		</select>
	    </div>
	</div>	
         
     <!--**********************************************-->
     
	<div class="control-group">
	    <label class="control-label" for="basicinput">Enter Donee ID</label>
	    <div class="controls">
		<input type="text" id="txtDoneeId" name="txtDoneeId" placeholder="00001" class="span8">
		<span class="help-inline">Numeric only:Search below if you don't Remember</span>
	    </div>
	</div>
         <!--**********************************************88-->
        <div class="control-group">
            <span class='span10' id="lblDonee"></span>
	    
	</div>
         
        <!--/***********************************************-->
									
	<div class="control-group">
	    <div class="controls">
                <button  id="submit" class="btn" disabled="disable">Assign Now</button>
                <a href="{{route('home')}}" class="menu-icon">Cancel</a>
	    </div>
	</div>
    </form>
  </div>
    
   <div class="module-body table">
     <table id='user_table' class="span8 table table-bordered table-striped display-1">
	<thead>
	  <tr>
	    <th>ID</th>
	    <th>First Name</th>
            <th>Mid Name </th>
            <th>Last Name </th>
            <th>Mobile </th>
            <th>Address</th>
	  </tr>
	</thead>
        <tbody>
        </tbody>
      </table>
    </div>
						
    
</div>
       
     
     
     
    

     <!-- Script -->
      
     

     <script type='text/javascript'>
     $(document).ready(function(){
               
         $("#lblDonee").hide();
       // Fetch all records as of now is not used
       $('#but_fetchall').click(function(){
	   fetchRecords(0);
       });

       // Search by userid
       $('#txtDoneeId').keyup(function(){
           $("#lblDonee").empty();
           
          var userid = Number($('#txtDoneeId').val().trim());
				
	  if(userid > 0){
	    fetchRecords(userid);
	  }
          else
          {
               $("#submit").prop('disabled',true);
               $("#lblDonee").empty();
          }

       });
      $('#user_table').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('users-list') }}",
           columns: [
                    { data: 'donee_id', name: 'donee_id' },
                    { data: 'fname', name: 'fname' },
                    { data: 'mname', name: 'mname' },
                    { data: 'lname', name: 'lname' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'address', name: 'address' }
                   
                 ]
        });


     });

     function fetchRecords(id){
         
       $.ajax({
         url: 'getDonees/'+id,
         type: 'get',
         dataType: 'json',
         success: function(response){

           var len = 0;
           $('#user_table tbody').empty(); // Empty <tbody>
           if(response['data'] != null){
             len = response['data'].length;
           }

           if(len > 0){
             for(var i=0; i<len; i++){
               var id = response['data'][i].donee_id;
               var username = response['data'][i].fname;
               var name = response['data'][i].lname;
               var email = response['data'][i].email;

               var tr_str = "<tr>" +
                   "<td align='center'>" + id + "</td>" +
                   "<td align='center'>" + username + "</td>" +
                   "<td align='center'>" + name + "</td>" +
                   "<td align='center'>" + email + "</td>" +
               "</tr>";

                        $("#user_table tbody").append(tr_str);
                        
               
             }
           }else if(response['data'] != null){
            $("#lblDonee").show();
              var tr_str = "<div class='alert alert-info'> <b> User ID:" +
                  response['data'].donee_id +'[Name:]->' + response['data'].lname +', '+ response['data'].fname +' '+ response['data'].mname+'[Address]:->'+
                   response['data'].address +'<br> email:' + response['data'].email +'[Mobile]:-> '+ response['data'].mobile   
              "</b></div>";
               $("#submit").prop('disabled',false);

              $("#lblDonee").append(tr_str);
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
     </script>
@endsection;