<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sapp\donar;
use App\donee;
use App\RecieptBook;
use App\assignbook;
use DB;
use Illuminate\Support\Facades\Session;
use App\Traits\Num2WordTrait;
use App\Traits\Convert2PdfTrait;
use App\sapp\optionlabel;
use App\sapp\estbregistration;

class RecieptBooksController extends Controller
{
    public $getsess;
    use Num2WordTrait;
    use Convert2PdfTrait;
     public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        
    }
    public function index()
    {
        //
        
    }
   
    public function generateReceiptBookPDF($id)
    {
     $getBookNo = RecieptBook::getDoneeByAssignmentID($id);
     $bookno = 'Book no'.$getBookNo->book_no;//to be used as title of pdf
      return  $this->convert2Pdf($this->ConvertReceiptBookHTML($id),$bookno);
        
    } 
   
    public function ConvertReceiptBookHTML($assignmentId)
    {
        $AssignmentDetail = RecieptBook::getDoneeByAssignmentID($assignmentId);
        $receiptbook_data = donar::getDonarsByAssignmentID($assignmentId);
        $nolUnused = $AssignmentDetail->nol-$AssignmentDetail->nol_used;
        $fullname=$AssignmentDetail->fname.' '.$AssignmentDetail->mname.' '.$AssignmentDetail->lname;
        $output ='<main><h4 align="center">Donars Detail from Receipt Book No:-'.$AssignmentDetail->book_no.'-'.$AssignmentDetail->bookmode.'</h4>';
        $output .= '<table width="100%" border="1px"style="border-style:dotted;font-size:11px;font-family: DejaVu Sans; sans-serif;">'
                .'<tr><td style="border:0px solid; padding:12px width:50%"><ul><li>Donee:<b>'.$fullname.'</b>('.$this->showDoneeType($AssignmentDetail->donee_type).')</li><li>Issued on:<b>'.date('d-m-Y',strtotime($AssignmentDetail->created_at)).'</b></li><li>Status:<b>'.$this->showAssignmentStatus($AssignmentDetail->status,$AssignmentDetail->updated_at).'</b></li><li>No of leaves Used:<b>'.$AssignmentDetail->nol_used.'</b></li><li>No of leaves Unused:<b>'.$nolUnused.'</b></li></ul></td>'
                . '<td style="border:0px solid; padding:12px width:50%"><ul><li>Total Cash Amount:<b>&#8377; '.donar::TotalDonationReceived($assignmentId,"By Cash").'</b></li><li>Total Cheque Amount:<b>&#8377; '.donar::TotalDonationReceived($assignmentId,"By Cheque").'</b></li><li>Total Amount of eTransfers:<b>&#8377; '.donar::TotalDonationReceived($assignmentId,"By eTransfer").'</b></li><li>No of Leaves Cancelled:<b>'.donar::countDonationReceived($assignmentId, "CANCELLED").'</b></li><li>Amount Deposited<b>&#8377; '.donar::TotaldonationDeposited($assignmentId).'</b><small>('.$this->Num2Word(donar::TotaldonationDeposited($assignmentId)).')</small></li></ul></td></tr>'
                . '</table><br>';
        $output .= '<table width="100%" style="border-collapse:collapse; border:0px;font-size:13px">'
                . '<tr><th style="border:1px solid; padding:12px width:20%">R No</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Donar</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Address</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Phone</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Donation</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Pay Mode</th></tr>';
        foreach($receiptbook_data as $receiptbookdonars)
        {
            $output.='<tr><td style="border:1px solid; padding:12px">'.$receiptbookdonars->drRno.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$receiptbookdonars->drname.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$receiptbookdonars->draddress.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$receiptbookdonars->drmobile.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$receiptbookdonars->drAmount.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$receiptbookdonars->drAmtype.'</td></tr>';
        }
        $output .= '</table><br><br>';
        
        
        return $output;
    }
    
    /*
     * Function : ShowRecieptBookAssignmentDetails   
     * parameter: Assignment ID 
     * Return : All detail associated with particular assignment No
     * e.g  it will return , name of the donee, address , no of leaves in 
     * receiptbook, serial no's of reciept book , current status,date of issue
     * no of leaves used and left, date of return and many more.
     */
    public function ShowReceiptBookAssignmentDetail($AssignmentID)
    {
        $AssignmentDetail = RecieptBook::getDoneeByAssignmentID($AssignmentID);
        $donarDetail = donar::getDonarsByAssignmentID($AssignmentID);
        $status = $this->showAssignmentStatus($AssignmentDetail->status,$AssignmentDetail->updated_at);     
        $MemType = $this->showDoneeType($AssignmentDetail->donee_type);
        $checkRegistration = estbregistration::checkEstbRegistration2();
        if(!$checkRegistration->isEmpty()){$check='1';}else{$check='0';}
       
        $Assigndetail=[
            'assignID'=>$AssignmentID,
            'rbid'=>$AssignmentDetail->rb_id,
            'fullname'=>$AssignmentDetail->fname.' '.$AssignmentDetail->mname.' '.$AssignmentDetail->lname,
            'issuedon'=>date('d-m-Y',strtotime($AssignmentDetail->created_at)),
            'status'=>$status,
            'bookno'=>$AssignmentDetail->book_no,
            'nolused'=>$AssignmentDetail->nol_used,
            'nolNused'=>$AssignmentDetail->nol-$AssignmentDetail->nol_used,   
            'memtype'=>$MemType,
            'Rbstatus'=>$AssignmentDetail->rbstatus,
            'Abstatus'=>$AssignmentDetail->status,
            'bookmode'=>$AssignmentDetail->bookmode,
            'doneepic'=>$AssignmentDetail->doneePic,
            'donarDetail'=>$donarDetail,
            'checkregistration'=>$check
            
        ];
        return view('dbReports/ShowReceiptBookAssignmentView')->with($Assigndetail);
    }
    public  function showAssignmentStatus($Objstatus,$statusUpdate)
    {
        if($Objstatus==='H'){
          return  $status="Retained";
        }else{
          return $status="Returned on :-".date('d-m-Y',strtotime($statusUpdate));
             }
    }
    public  function showDoneeType($objDtype)
    {
         switch($objDtype){
             case 'BM':
                return $MemType = "Basic Member";
                 break;
             case 'EM':
                 return $MemType = "Employee";
                 break;
             case 'GM':
                 return $MemType = "General Member";
                 break;
             default:
                 return $MemType = "Volunteer";
         }
        
    }
    /*function RecieveRBook
     * parameter assignment ID
     * Return void
     */
    public function RecieveRBook($assignmentID)
    {
        assignbook::updateStatus($assignmentID);
        $AssignmentDetail = RecieptBook::getDoneeByAssignmentID($assignmentID);
        $rbid =$AssignmentDetail->rb_id;
        Recieptbook::updateRbookStatus2Open($rbid);
        return redirect()->back()->with('message','Book Received Successfully');
    }
    public function CloseRBook($rbid)
    {
        RecieptBook::updateStatus($rbid);
        return redirect()->back()->with('message','Book Closed Successfully');
    }
    public function DoneesList()// datatable view listed in assign book view.
    {
        $donees=DB::table('donees')->select('*');
        return datatables()->of($donees)
                ->make(true);
    }
    
     public function getDonees($id)
    {
        //fetch all donee data
        $doneeData['data']= donee::getDoneeData($id);
        echo json_encode($doneeData);
        exit;
    }
     
    public function create()
    {
        $getsess = Session::get('fyindex');
        if(auth()->user()->is_admin==1 && Session::get('FyStatus')==='A'){
            $EstbBooks = optionlabel::getOptionData('EstbBook');
            $data = [
                'getsess'=>$getsess,
                'estbBooks'=>$EstbBooks
                    ];
        return view('partials/registerbooks',with($data));
        
        }
        else
        {
            return redirect('home')->with('status',"Access Denied! You are not authorised to access");
        }
    }
   Protected function  AddNewRecieptBook(Request $request)
    {
        $request->validate([
            'txtBookNo'=>'required|numeric',
            'txtFrom'=>'required|numeric',
            'txtTo'=>'required|numeric',
            'txtNol'=>'required|numeric'
            
        ]);
        $recieptbook = new RecieptBook();
        $recieptbook->book_no = request('txtBookNo');
        $recieptbook->rno_from = request('txtFrom');
        $recieptbook->rno_to = request('txtTo');
        $recieptbook->nol = request('txtNol');//nol=number of leaves in reciept book.
        $recieptbook->bookmode = request('optBookMode');
        $recieptbook->status = 'O';
        
        $recieptbook->save();
        return redirect()->back()->with('message','Saved Successfully');
                
    }
    public function VassignRbooks()
    {
       if(auth()->user()->is_admin==1 && Session::get('FyStatus')==='A'){
        $dbAssignBooks = DB::table('recieptbooks')
                ->where('status','O')
                ->skip('0')->take('20')
                ->orderBy('id')
                ->get()
                ->toArray();
        return view('partials/assignbooks',compact('dbAssignBooks'));
       
        
        }
        else
        {
            return redirect('home')->with('status',"Access Denied! You are not authorised to access");
        }  
    }
    
    
    public function addAsignRbooks(Request $request)
    {
        $assign = new assignbook();
        $updateRbook = new RecieptBook();
        $assign->donee_id = request('txtDoneeId');
        $assign->rb_id = request('optRbook');
        $assign->fy_id = Session::get('fyindex');
        $assign->status = 'H'; // H = Hold R=Returned.
        $updateRbook->updateRbookStatus(request('optRbook'));
        $assign->save();
       
        return redirect()->back()->with('message','Successfully Assigned to User Id- '.request('txtDoneeId'));        
    }
    public function disposeRecieptbook()
    {
        $OpenRbook = RecieptBook::openRbook();
        $VData= [
             'vdata'=>$OpenRbook
        ];
        return view('partials/disposebooks',with($VData));
    }
    public function disposedRecieptbookPDF()
    {
        return  $this->convert2Pdf($this->disposedReceiptbookHTML(),"title");
    }
    public function disposedReceiptbookHTML()
    {
        $DiposedRbook = RecieptBook::DisposedRbook();
        $output = '<table width="100%" style="border-collapse:collapse; border:0px;font-size:13px">'
                . '<tr><th style="border:1px solid; padding:12px width:20%">RBID</th>'
                . '<th style="border:1px solid; padding:12px width:20%">BookNo</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Rcpt-From</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Rcpt_To</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Nol</th>'
                . '<th style="border:1px solid; padding:12px width:20%">NolU</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Estb</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Opened-On</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Closed-On</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Done-Id</th></tr>';
        foreach($DiposedRbook as $disposed)
        {
            $output.='<tr><td style="border:1px solid; padding:12px">'.$disposed->id.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->book_no.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->rno_from.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->rno_to.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->nol.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->nol_used.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->bookmode.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->created_at.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->updated_at.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$disposed->donee_id.'</td></tr>';
        }
        
        $output .= '</table><br><br>';
        
        
        return $output;
    }
    
}
    
