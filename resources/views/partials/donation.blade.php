@extends('layouts.admin')
@section('content')

<style>
.my_bg-class {
 background:olive;
}
.error
{
color:red;
font-family:verdana, Helvetica;
}
</style>
<div class="module">
  <div class="module-head">
    <h3>Donars Books</h3>
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
     <form class="form-horizontal row-fluid" id='donarsform' name="donarsform" method="POST" action="{{route('acceptDonation')}}">
         @csrf
         <!--**********************************************-->
	<div class="control-group">
            <div class="well my_bg-class">
	    <div class="control-group">
	    <div class="controls">
                <div class='input-prepend'>
                    <span class="add-on">Enter Book No:</span><input type="text" id="txtBookNo" name="txtBookNo" placeholder="1234" class="span8" required="" value="{{old('txtBookNo')}}">
                     </div>
	    </div>
	      </div>
                <span class='span10' id="lblDonee"></span> <br>
                <span class='span10' id="lblDonee2"></span>
	    </div>
            <input type="hidden" name="abid" id="abid">
	</div>
         <!--**********************************************--> 
          <span class='span10' id="msg"></span>
         <div class="control-group">
	    <label class="control-label" for="txtRecieptNo">Reciept No:</label>
	    <div class="controls">
                <input class="span3" type="text" id="txtRecieptNo" name="txtRecieptNo" required="">
                <span class='inline'>Date:
                    <input class="span3"  type="text" id='dpDate' name="dpDate"  required="" value="{{old('dpDate')}}">
                </span>
                <span class =" inline">Gender: <select data-placeholder="Gender" class="span3" id = "optGender" name="optGender" required="">
                   <option value="M">Male</option>
                    <option value="F">Female</option>
		    
		</select></span>
	    </div>
           
	    
	</div>	
          <!--/***********************************************-->
          <div class="control-group">
	    <label class="control-label" for="txtDonarName">Donar Name:</label>
	    <div class="controls">      
                <input class="span8" type="text" id="txtDonarName" name="txtDonarName" required="" value="{{old('txtDonarName')}}">
               
            </div>	    
	</div>	
          <!--*********************************************************-->
          <div class="control-group">
	 <label class="control-label" for="address">Address</label>
	     <div class="controls">
                 <textarea class="span8"name='txtAddress'id='txtAddress' rows="5" required="">{{old('txtAddress')}}</textarea>
	     </div>
        </div>
          <!--************************************************************-->
          <!--**********************************************--> 
         <div class="control-group">
	    <label class="control-label" for="basicinput">Mobile:</label>
	    <div class="controls">
                <input class="span3" type="text" id="txtMobileNo" name="txtMobileNo" value="{{old('txtMobileNo')}}">
                <span class =" inline">Donation Type: <select data-placeholder="Donation Type" class="spa
                n4" id = "optDonationType" name="optDonationType">
                     @foreach($donationOptions as $donation)
                        <option value="{{$donation->shortname}}">{{$donation->optionname}}</option>
                     @endforeach
		    
		</select></span>
	    </div>
           
	    
	</div>	
          <!--/***********************************************-->
         
  
	<div class="control-group">
	    <label class="control-label" for="">Amount:</label>
	    <div class="controls">
		<div class="input-prepend">
                    <span class="add-on">&#8377;</span><input class="span8" type="text" id="txtAmount" required="true" name="txtAmount" value="{{old('txtAmount')}}">  
                </div>
                <label class="radio inline">
                    <input type="radio" name="optAmtType" id="optAmtType1" value="By Cash" required="">
	Cash
	</label> 
	<label class="radio inline">
            <input type="radio" name="optAmtType" id="optAmtType2" value="By Cheque" required="">
	Cheque
	</label> 
	<label class="radio inline">
            <input type="radio" name="optAmtType" id="optAmtType3" value="By eTransfer" required="">
	eTransfer 
	</label>
            </div>            
        </div>
          
                  <!--**********************************************-->
                  
                  
          <div class="control-group">
              <label class="control-label">Cheque No:</label>
              <div class="controls">
                  <span class="input inline"><input type="text" class="span8" name='txtcheque' id = "txtcheque"disabled="disable" value="{{old('txtcheque')}}"></span>
              </div><br>
              <label class="control-label">Bank Details:</label>
               <div class="controls">
                   <span class="input inline">
                       <select data-placeholder="Donation Type" class="span4" id = "optBank" name="optBank" disabled="disable">
                   @foreach($bankOptions as $banks)
                           <option value="{{$banks->shortname}}">{{$banks->optionname}}</option>
                    @endforeach
		</select></span>
              </div>
          </div>
         <!--**********************************************-->  
         <div class="control-group">
	    <div class="controls">
                <button type="submit" class="btn btn-info" id="btnsave" >Save</button>
                <a href="{{route('home')}}" class="menu-icon">Cancel</a>
	    </div>
	</div>
    
    </form>
  </div>
</div>
<!-- javascript call for datepicker -->
<script type="text/javascript"> 
    var RecieptNoFrom;
    var RecieptNoTo;
    
   
         $('#txtBookNo').blur(function(){
           $("#lblDonee").empty();
            var bookno = Number($('#txtBookNo').val().trim());  			
	    if(bookno > 0){
	       fetchRecords(bookno);
                $("#btnsave").prop('disabled',false);
	       }
               else
               {
                 $("#btnsave").prop('disabled',true);
                 $("#lblDonee").empty();
               }
            });
            
            // checking valid range of recipt book
           

         
  function fetchRecords(bookNo){
         
       $.ajax({
         url: 'getDoneesByBookNo/'+bookNo,
         type: 'get',
         dataType: 'json',
         success: function(response){
            if(response['data'] != null){
            $("#lblDonee").show();
            var DoneeName = response['data'].fname+' '+ response['data'].mname+' '+ response['data'].lname;
            var DoneeAddress = response['data'].address;
            var DoneeMobile = response['data'].mobile
            RecieptNoFrom = response['data'].rno_from
            RecieptNoTo = response['data'].rno_to
            var RecieptBookMode = response['data'].bookmode
            var AssignmentNo = response['data'].ab_id
            
              var tr_str = "<p class='text-muted font-italic'>[ " +
                    DoneeName+'--'+DoneeAddress+'--'+DoneeMobile+' R-No-From '+RecieptNoFrom+' To '+RecieptNoTo+' - '+RecieptBookMode
                +" ] Assignment ID: "+AssignmentNo+"</p>";
               $("#abid").val(AssignmentNo);
                $("#txtRecieptNo").prop('disabled',false);
               $("#btnsave").prop('disabled',false);

              $("#lblDonee").append(tr_str);
           }else{
               
              var tr_str = "<div class='alert alert-danger'><b> Reciept Book Not Available or May have been Closed</b></div>";
              $("#lblDonee").append(tr_str);
              $("#txtRecieptNo").prop('disabled',true);
              $("#btnsave").prop('disabled',true);
           }

         }
       });
     }
     $(function(){
     $('#dpDate').datepicker({
  dateFormat: 'dd-mm-yy', //check change
  changeMonth: true,
  changeYear: true
      });
  });
   
   $('#txtRecieptNo').change(function(){
       $("#msg").empty();
       var recieptno = Number($('#txtRecieptNo').val().trim());
       if(recieptno>=Number(RecieptNoFrom) && recieptno<=Number(RecieptNoTo)){
           $("#btnsave").prop('disabled',false);
           $("#lblDonee2").empty();
       }
       else
       {
          $("#btnsave").prop('disabled',true);
           var tr_str = "<div class='alert alert-danger'><b> Reciept Number Not Available in this book</b></div>";
              $("#lblDonee2").append(tr_str);
       }
         
       
   });
   $("input[name='optAmtType']").change(function(){
      if($('input:radio[id=optAmtType2]:checked').val()==="By Cheque")
      {
         $("#txtcheque,#optBank").prop('disabled',false); 
      }
      else
         $("#txtcheque,#optBank").prop('disabled',true);
   });
  
    </script>

@endsection