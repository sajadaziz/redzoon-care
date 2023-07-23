@extends('layouts.admin')
@section('content')
<div class="module">
  <div class="module-head">
        <h3>Account Detail {{$acid}}</h3>
  </div>
  <div class="module-body">
      <table width="100%" border="1px"style="border-style:dotted;font-size:14px;font-family: DejaVu Sans; sans-serif">'
       <tr>
           <td style="border:0px solid; padding:12px width:50%">
               <ul>
                   <li>Account Title: {{$expandeddetail->title}}</li>
                   <li>Name Of the Bank: {{$expandeddetail->bankname}}</li>
                   <li>Account for establishment: {{$expandeddetail->establishment}}</li>
                   <li>Purpose of the Account: {{$expandeddetail->purpose}}</li>
               </ul>
           </td>
           <td style="border:0px solid; padding:12px width:50%">
               <ul>
                   <li> Account Type @if($expandeddetail->atype ==='CA')
                   Current Account @else Saving Account @endif</li>
                   <li>Branch: {{$expandeddetail->branch }} </li>
                   <li>IFSC Code: {{$expandeddetail->ifsc }} </li>
               </ul>
               <a href="{{route('downloadAccountDetail',$acid)}}">Download </a><small>All Transactions</small>
           </td>
       </tr>
     </table>
      <div class="module-body table"><span>Mini Statement <small>(30 latest Transactions only)</small></span>
     <table id='user_table' class="span8 table table-bordered table-striped display-1">
	 <thead><tr>
                 
                  <th>Date</th>
		  <th>Particulars</th>
                  <th>Cr/Dr</th>
                  <th>Deposits</th>
                  <th>Withdrawals </th>
                  <th>Balance</th>
                                                                          
		</tr>
	 </thead>
         <tbody>
             @foreach($acountdetail as $data)
             <tr>
                 <td>{{date('d-M-Y',strtotime($data->trnxDate))}}</td><td>{{$data->particulars}}</td><td>{{$data->TrnxM}}</td><td>{{$data->deposits}}</td><td>{{$data->withdrawal}}</td><td>{{$data->balance}}</td>
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