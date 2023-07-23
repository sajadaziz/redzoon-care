@extends('layouts.admin')
@section('content')
 <!--/.span3-->
                <div class="span9">
                    <div class="content">
                        <div class="module">
                            <div class="module-body">
                                <div class="profile-head media">
                                    <small class="pull-left">[{{$flag}}]</small>
                                    <div class="media-body">
                                         @if(session()->has('message'))
                                          <div class="alert alert-success">
                                          {{ session()->get('message') }}
                                             </div>
                                        @endif
                           
                                        <h4>
                                           Fiscal Year intialisation 
                                        </h4>
                                        <p class="profile-brief">
                                           
                                        start new year intialisation
                                        </p>
                                        
                                    </div>
                                </div>
                                
                                <ul class="profile-tab nav nav-tabs">
                                    <li class="active"><a href="#open" data-toggle="tab">Open New FY</a></li>
                                    <li><a href="#close" data-toggle="tab">Close FY</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="open">
                                       <!-- Tab 1 starts from here--->
                                       <div class="module">
  <div class="module-head">
      <h3>Intialize New Financial Year.</h3>
  </div>
  <input type="hidden" name="FyFlag" id="FyFlag" value="{{$flag}}">
  <div class="module-body">   
     <form class="form-horizontal row-fluid" method="get" name="fyopen" action="{{route('savefyintialisation')}}">
         {{ csrf_field() }}
        
         <!--**********************************************88-->
         
        <div class="form-group{{ $errors->has('Fy-Starts') ? ' has-error' : '' }}">
	    <label class="control-label" for="Fy-Starts">FY Starts</label>
	    <div class="controls">
		<input class="span3" value="{{ old('Fy-Starts')}}"  type="text" id='Fy-Starts' name="Fy-Starts" style="cursor: grab"placeholder="dd/mm/yyyy">  
            <small class="alert-danger">{{ $errors->first('Fy-Starts') }}</small>
            </div>
	</div>
         <br>
         <div class="form-group{{ $errors->has('Fy-Ends') ? ' has-error' : '' }}">
	    <label class="control-label" for="Fy-Ends">FY Ends</label>
	    <div class="controls">
	      <input class="span3" type="text" name="Fy-Ends" id='Fy-Ends' placeholder="dd/mm/yyyy">     
	   <small class="alert-danger">{{ $errors->first('Fy-Ends') }}</small>
            </div>
	</div>
         <br>
        <!--/***********************************************-->							
	<div class="control-group">
	    <div class="controls">
        	<button type="submit" class="btn" id="btnSaveFy">Save</button>
                <a href="{{route('home')}}" class="menu-icon">Cancel</a>
	    </div>
	</div>
    </form>
  </div>
   
</div>
<script type='text/javascript'>
    $("#Fy-Starts").change( function () {

        var str = $("#Fy-Starts").val();

        if( /^\d{2}\/\d{2}\/\d{4}$/i.test( str ) ) {

            var parts = str.split("/");

            var day = parts[0] && parseInt( parts[0], 10 );
            var month = parts[1] && parseInt( parts[1], 10 );
            var year = parts[2] && parseInt( parts[2], 10 );
            var duration = 1;

            if( day <= 31 && day >= 1 && month <= 12 && month >= 1 ) {

                var expiryDate = new Date( year, month-1, day-1 );
                expiryDate.setFullYear( expiryDate.getFullYear() + duration);

                var day = ( '0' + expiryDate.getDate() ).slice( -2 );
                var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
                var year = expiryDate.getFullYear(); 
                $("#Fy-Ends").val( day + "/" + month + "/" + year );
                $("#Fy-Ends").focus();

            } else {
               $("#Fy-Ends").val('error-98');
            }
        }
        else
        {
            $("#Fy-Ends").val('Invalid-102');
        }
    });

 
    $(document).ready(function () {
        $('input[id$=Fy-Starts]').datepicker({
            dateFormat: 'dd/mm/yy'			// Date Format "dd-mm-yy"
        });
        var flag = $("#FyFlag").val();
        if(flag==='A')
        {
            $("#btnSaveFy").prop('disabled',true);
            $("#btnCloseFy").prop('disabled',false);
        }
        else
        {
            $("#btnSaveFy").prop('disabled',false);
            $("#btnCloseFy").prop('disabled',true);
        }
    });
     </script>
                                      
                                    </div>
                                    <div class="tab-pane fade" id="close">
                                         <!-- Tab 2 starts from here--->
         <form class="form-horizontal row-fluid" name="fyclose" method="get" action="{{route('closeandArchive')}}">
         {{ csrf_field() }}
        
         <!--**********************************************88-->
         
        <div class="form-group{{ $errors->has('Fy-totDonars') ? ' has-error' : '' }}">
	    <label class="control-label" for="Fy-totDonars">Total Donars</label>
	    <div class="controls">
                <input class="span3" value="{{ $totDoners}}"  type="text" id='Fy-totDonars' name="Fy-totDonars" readonly="readonly" >  
            <small class="alert-danger">{{ $errors->first('Fy-totDonars') }}</small>
            </div>
	</div>
         <br>
         <div class="form-group{{ $errors->has('Fy-totCollection') ? ' has-error' : '' }}">
	    <label class="control-label" for="Fy-totCollection">Total Collection</label>
	    <div class="controls">
                <input class="span3" type="text" name="Fy-totCollection" id='Fy-Ends'readonly="readonly" value="{{$totCollection}}">     
	   <small class="alert-danger">{{ $errors->first('Fy-totCollection') }}</small>
            </div>
	</div>
         <br>
          <div class="form-group{{ $errors->has('Fy-totDonars') ? ' has-error' : '' }}">
	    <label class="control-label" for="Fy-totBenificiaries">Total Benificiaries</label>
	    <div class="controls">
                <input class="span3" value="0"  type="text" id='Fy-totBenificiaries' name="Fy-totBenificiaries" readonly="readonly">  
            <small class="alert-danger">{{ $errors->first('Fy-totBenificiaries') }}</small>
            </div>
	</div>
         <br>
         <div class="form-group{{ $errors->has('Fy-totDisbursment') ? ' has-error' : '' }}">
	    <label class="control-label" for="Fy-totDisbursment">Total Disbursment</label>
	    <div class="controls">
                <input class="span3" type="text" name="Fy-totDisbursment" id='Fy-totDisbursment'readonly="readonly" value="0">     
	   <small class="alert-danger">{{ $errors->first('Fy-totDisbursment') }}</small>
            </div>
	</div>
         <br>
         <div class="form-group{{ $errors->has('Fy-totDisbursment') ? ' has-error' : '' }}">
	    <label class="control-label" for="Fy-remarks">Remarks</label>
	    <div class="controls">
                <textarea class="span8"  name="Fy-remarks" id='Fy-remarks'rows='5'></textarea> 
	   <small class="alert-danger">{{ $errors->first('Fy-remarks') }}</small>
            </div>
	</div>
         <br>
        <!--/***********************************************-->							
	<div class="control-group">
	    <div class="controls">
        	<button type="submit" class="btn" id="btnCloseFy">Close FY and Archive</button>
                <a href="{{route('home')}}" class="menu-icon">Cancel</a>
	    </div>
	</div>
    </form> 
                                        
                                    </div>
                                </div>
                            </div>
                            <!--/.module-body-->
                                  <div class="module">
  <div class="module-head">
    <h3>Archive's</h3>
  </div>
  <div class="module-body">           
         <!--**********************************************88-->
         <table class="table table-striped table-bordered table-condensed">
	   <thead>
	     <tr>
		 <th>FYID</th>
                 <th>FY-Start</th>
		 <th>FY-End</th>
		 <th>Total Collection</th>
                 <th>Total Donars</th>
                 <th>Total Disbursement</th>
                 <th>Total Benificiries</th>
                 <th>Archives</th>
	    </tr>
	 </thead>
	 <tbody>
             @foreach($closedFy as $data)
             <tr>
                 <td>{{$data->fy_id}}</td><td>{{$data->fyStart}}</td><td>{{$data->fyEnd}}</td>
                 <td>{{$data->totCollection}}</td><td>{{$data->totDonars}}</td><td>{{$data->totDisburse}}</td>
                 <td>{{$data->totBenificiary}}</td>
                 <td><a href="{{route('fy.archived',['fyid'=>$data->fy_id,'fystart'=>$data->fyStart,'fyend'=>$data->fyEnd])}}">Download</a></td>
             </tr>
             @endforeach
         </tbody>
       </table><br>
       
         
        <!--/***********************************************-->							
	
   
  </div>
   
</div>
                        </div>
                        <!--/.module-->
                    </div>
                    <!--/.content-->
                </div>
@endsection