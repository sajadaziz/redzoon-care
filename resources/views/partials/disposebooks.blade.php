@extends('layouts.admin')
@section('content')
<div class="module">
  <div class="module-head">
    <h3>Open Reciept Books</h3>
  </div>
  <div class="module-body">           
         <!--**********************************************88-->
         <table class="table table-striped table-bordered table-condensed">
	   <thead>
	     <tr>
		 <th>RbID</th>
                 <th>DoneId</th>
                 <th>BOOK NO</th>
		 <th>Reciept No From</th>
		 <th>Reciept No To </th>
                 <th>NoL</th>
                 <th>NoL Used</th>
                 <th>Establishment</th>
                 <th>Open Since</th>
                 <th>Dispose</th>
	    </tr>
	 </thead>
	 <tbody>
            @foreach($vdata as $data)
            <tr><td>{{$data->id}}</td><td>{{$data->donee_id}}</td><td>{{$data->book_no}}</td><td>{{$data->rno_from}}</td><td>{{$data->rno_to}}</td>
            <td>{{$data->nol}}</td><td>{{$data->nol_used}}</td><td>{{$data->bookmode}}</td><td>{{$data->created_at}}</td>
            <td> <a href="{{ url ('CloseRBook',$data->id)}}" class="btn btn-warning" id ="linkR" onclick="return confirm('Are you sure, you want to close this book?After that you will not be able to insert data in this book')"> <i class="icon-ban-circle shaded"></i></a></td></tr>
            @endforeach
         </tbody>
       </table><br>
       <a href="{{route('dispRbPdf')}}" class="btn btn-info" id="btndownload"><i class="icon-download shaded"></i>View Disposed Receipt books</a>
       
         
        <!--/***********************************************-->							
	
   
  </div>
   
</div>
@endsection
<!---->