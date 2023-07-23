@extends('layouts.admin')
@section('content')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<div class="module">
  <div class="module-head">
    <h3>Reciept Books allocated in Current FY</h3>
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
     
  </div>
    <div class=" alert alert-info">If Status shows <mark>Retained</mark> it means Book is still in member's possession  and has not been returned yet.<br>
        and if it shows 'Returned' it means Receipt book has been returned by donee or member</div>
   <div class="module-body table">
     <table id='user_table' class="span8 table table-bordered table-striped display-1">
	<thead>
	  <tr>
	    <th>Donee ID</th>
            <th>F-Name</th>
            <th>M-Name</th>
            <th>L-Name</th>
            <th>Book No </th>
            <th>Donee Name </th>
            <th>Status</th>
            
	    
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
           ajax: "{{ url('user-list') }}",
           columns: [
                    { data: 'donee_id', name: 'donee_id'}, 
                    { data: 'fname', name: 'fname',visible:false},
                    { data: 'mname', name: 'mname',visible:false},
                    { data: 'lname', name: 'lname',visible:false},
                    { data: 'book_no', name:'book_no'},
                    { data: 'ab_id' , name: 'ab_id',orderable: false, searchable: false}, 
                    { data: 'status', render: function(data){
                            if(data==='R')
                            {
                                return 'Returned'
                            }
                            else{return '<mark>Retained</mark>'}
                    } }
                    ],
            order:[[4,'asc']] //this line will set order by ab_id
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