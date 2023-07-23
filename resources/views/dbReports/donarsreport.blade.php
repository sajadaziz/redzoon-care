@extends('layouts.admin')
@section('content')
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<div class="module">
  <div class="module-head">
        <h3>Donars Report of {{$fy}}</h3>
  </div>
  <div class="module-body">
      <table width="100%" border="1px"style="border-style:dotted;font-size:14px;font-family: DejaVu Sans; sans-serif;">'
       <tr>
           <td style="border:0px solid; padding:12px width:50%">
               <ul>
                  <li><dt>Male donors : </dt><dd>{{$CountMaleDonars}}</dd></li>
                 <li><dt>Female donors : </dt><dd>{{$CountFemaleDonars}}</dd></li>
                 <li><dt>Total Donars : </dt><dd>{{$totalDonarsInEstablishment}}</li>
               </ul>
           </td>
           <td style="border:0px solid; padding:12px width:50%">
               <ul>
                   
                   <li><dt>Collection from male donors : </dt><dd> &#8377;{{$estbMCol}}&nbsp;&nbsp;<small>({{$estbMColWord}})</small></dd></li>
                   <li><dt>Collection from Female donors : </dt><dd> &#8377;{{$estbFCol}}&nbsp;&nbsp;<small>({{$estbFColWord}})</small></dd></li>
                   <li><dt> Total Collection : </dt><dd> &#8377;{{$estbCol}}&nbsp;&nbsp;<small>({{$estbColWord}})</small></dd></li>
               </ul>
           </td>
       </tr>
     </table>
       @if($checkregistration==='0')
       <br>a href="#" class="btn btn-info" disabled='disabled'><i class="icon-download"></i>Download</a>
       <small class="alert alert-warning">Please Register to get download button enabled</small>
       @else
       <span class="btn btn-inverse"><i class="icon-download"></i><a href="{{route('downloadPDFestb',$estb)}}">Download</a></span>
      @endif
       <div class="module-body table">
     <table id='user_table' class="span8 table table-bordered table-striped display-1">
	 <thead>
									<tr>
									  <th>Reciept No'</th>
                                                                          <th>Donar Name</th>
									  <th>Address</th>
									  <th>Phone</th>
                                                                          <th>Deposit</th>
                                                                          <th>Amount</th>
                                                                          
									</tr>
								  </thead>
								  <tbody>
                                                                   @foreach($DonarsListofCurrentFY as $Ddetail)
									<tr>
                                                                               <td>{{$Ddetail->drRno}}</td>
                                                                                <td>{{$Ddetail->drname}}</td>
                                                                                <td>{{$Ddetail->draddress}}</td>
                                                                                <td>{{$Ddetail->drmobile}}</td>
                                                                               
                                                                                <td>&#8377;{{$Ddetail->drAmount}}</td>
                                                                                 <td>{{$Ddetail->drAmtype}}</td>
                                                                                                                                                             
                                                                                                                                                         </tr>                                                     
                                                                  @endforeach
                                                                  </tbody>
      </table>
    </div>
      
  </div>
   
</div>
 <script type='text/javascript'>
     $(document).ready(function(){
       $('#user_table').DataTable();
       $('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');    
     });
</script>
@endsection