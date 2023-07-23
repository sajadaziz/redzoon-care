@extends('layouts.admin')
@section('content')


<div class="module">
  <div class="module-head">
    <h3>Accounts Book</h3>
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
     <form class="form-horizontal row-fluid" id='frmBanking' name="frmBanking" method="POST" action="{{route('AddBankTrnx')}}">
         @csrf
         <!--**********************************************-->
	<div class="control-group">
            <div class="well my_bg-class">
	    <div class="control-group">
	    <div class="controls">
                
                    <span class="in-line">Select Bank A/C No:</span>
                     <select data-placeholder="optbank" class="span4" id = "optBank" name="optBank" >
                         <option value=""selected="true">--Select--</option> 
                         @foreach($bankAccount as $data)
                           <option value="{{$data->acid}}">{{$data->actno}}</option>
                          @endforeach
		</select>
                     
	    </div>
                <div class="controls">
                
                    <span class="in-line small text-warning italic" id="spanAcountDetail">
                       ..
                    </span>
                     
                     
	    </div>
	      </div>
                 </div>
            <input type="hidden" name="abid" id="abid">	</div>
         <!--**********************************************--> 
          <span class='span10' id="msg"></span>
         <div class="control-group">
	    <label class="control-label" for="txtRecieptNo">Date:</label>
	    <div class="controls">
               
                <span class='inline'>
                    <input class="span3"  type="text" id='dpDate' name="dpDate" readonly="readonly" style="cursor: grab" required="" value="{{old('dpDate')}}">
                </span>
                <span class =" inline">Transaction Method :<select data-placeholder="Transaction Method" class="span3" id = "optTransactionMethod" name="optTransactionMethod" required="">
                        <option value="">--Select--</option>
                    <option value="Cr">Deposit</option>
                    <option value="Dr">Withdrawal</option>
		    
		</select></span>
	    </div>
           
	    
	</div>	
          <!--/***********************************************-->
          	
          <!--*********************************************************-->
          <div class="control-group">
	 <label class="control-label" for="txtParticulars">Particulars</label>
	     <div class="controls">
                 <textarea class="span8"name='txtParticulars'id='txtParticulars' rows="5" required="">{{old('txtParticulars')}}</textarea>
	     </div>
        </div>
          <!--************************************************************-->
          <!--**********************************************--> 
        
          <!--/***********************************************-->
         
  
	<div class="control-group">
	    <label class="control-label" for="">Amount:</label>
	    <div class="controls">
		<div class="input-prepend">
                    <span class="add-on">&#8377;</span><input class="span8" type="text" id="txtAmount" required="true" name="txtAmount" value="{{old('txtAmount')}}">  
                </div>
               
	
	
            </div>            
        </div>
          
                  <!--**********************************************-->
                  
                  
          
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
    $("#optBank").change(function(){
          $("#spanAcountDetail").empty();
            var acid = $("#optBank").val();  
	   fetchRecords(acid);
       });
    function fetchRecords(acid){//acid=account ID
         
       $.ajax({
         url: 'getAllBankData/'+ acid,
         type: 'get',
         dataType: 'json',
         success: function(response){
            if(response['data'] != null){
            
            
              var tr_str = "<p class='text-muted font-italic'>"+response['data'].title+"</p>";
               

              $("#spanAcountDetail").append(tr_str);
           }else{
               
              var tr_str = "No Record Found";
              $("#spanAcountDetail").append(tr_str);
             
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
    </script>

@endsection