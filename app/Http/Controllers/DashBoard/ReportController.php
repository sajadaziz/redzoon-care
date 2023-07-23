<?php

namespace App\Http\Controllers\DashBoard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\RecieptBook;
use App\donee;
use App\sapp\optionlabel;
use App\sapp\donar;
use App\Traits\Num2WordTrait;
use App\Traits\Convert2PdfTrait;
use App\sapp\estbregistration;
use App\bankaccount;
use App\bank;
class ReportController extends Controller
{
    //
    use Num2WordTrait;
    use Convert2PdfTrait;
    
    public function __construct() {
        parent::__construct();
        //below line was not working then i changed protected $middleware = [] in kernal.php to make to run
       // Session::get('fyindex');
    }
    public function dbrecieptbook()
    {        
           return view('dbReports/RptRecieptbook');
    }
    //temporary function 
    public function DList()// datatable view listed in assign book view.
    {
       $donees = new RecieptBook;
       
       $d = $donees->getListOfRecieptBookAssignments();
        return datatables()->of($d)
                ->addColumn('ab_id',function($d){
                 return "<a href='".url('view-detail',$d->ab_id)."'>".$d->fname.' '.$d->mname.' '.$d->lname."</a>";   
                })
                ->rawColumns(['ab_id'])
                ->make(true);
    }
    // temporary function ends here.
    public function AllEstbDonars()
    {
        $fyid = Session::get('fyindex');
        $estblist=  donar::getEstbListDonarsCount($fyid);
        $data=[
            'estbBook'=>$estblist,
            'fy'=>session::get('FyTitle')
            
        ];
        return view('dbReports/AllEstbDonars',with($data));
    }
    public function DonarsOfEstablishment($estb)
    {
          $fyid = Session::get('fyindex');
           $DonarsListofCurrentFY = donar::getDonarsListByEstb($estb, $fyid);
           $checkRegistration = estbregistration::checkEstbRegistration2();
                 if(!$checkRegistration->isEmpty()){$check='1';}else{$check='0';}
           $data=[
               'fy'=>session::get('FyTitle').'/'.$estb,
               'estb'=>$estb,
               'estbCol' => $this->getEstbDonarsCollection($estb,$fyid),
               'estbColWord' => $this->Num2Word($this->getEstbDonarsCollection($estb,$fyid)),
               'estbMCol' => $this->getEstbMDonarsCollection($estb,$fyid),
               'estbMColWord' =>$this->Num2Word($this->getEstbMDonarsCollection($estb,$fyid)),
               'estbFCol' => $this->getEstbFDonarsCollection($estb,$fyid),
               'estbFColWord' =>$this->Num2Word($this->getEstbFDonarsCollection($estb,$fyid)),
               'totalDonarsInEstablishment'=>$this->getEstbDonarsCount($estb,$fyid),
               'CountMaleDonars' =>$this->countMaleDonar($estb,$fyid),
               'CountFemaleDonars' => $this->countFemaleDonar($estb,$fyid),
               'DonarsListofCurrentFY'=>$DonarsListofCurrentFY,
               'checkregistration'=>$check
                
             ];
        return view('dbReports/donarsreport',with($data));
    }
    public function getEstbFDonarsCollection($estb,$fyid)
    {
        //$fyid = Session::get('fyindex');
        $femaleCol = donar::getFCollectionbyEstb($estb, $fyid);
        if($femaleCol == null)
        {
            return $femaleCol = 0;
        }
        else
        {
            return $femaleCol->FemaleDonation;
        }
    }
    public function getEstbMDonarsCollection($estb,$fyid)
    {
       // $fyid = Session::get('fyindex');
        $maleCol = donar::getMCollectionbyEstb($estb, $fyid);
        if($maleCol == null)
        {
            return $maleCol = 0;
        }
        else
        {
            return $maleCol->MaleDonation;
        }
    }
    public function getEstbDonarsCollection($estb,$fyid)
    {
       //$fyid = Session::get('fyindex');
        $TotEstbCol = donar::getCollectionbyEstb($estb,$fyid);
        if($TotEstbCol==  null)
        {
            return $TotEstbCol = 0;
        }
        else
        {
           return  $TotEstbCol->TotalDonation;
        }   
    }
    public function getEstbDonarsCount($estb,$fyid)
    {
       //$fyid = Session::get('fyindex');
        $totalDonarsInEstablishment = donar::getEstbDonarsCount($estb, $fyid);
        if($totalDonarsInEstablishment == null)
        {
            return $totalDonarsInEstablishment = 0;
        }
        else
        {
            return $totalDonarsInEstablishment->getEstbDonarsCount;
        }
    }

    public function countMaleDonar($estb,$fyid)
    {
        //$fyid = Session::get('fyindex');
        $totalmaledonars= donar::getEstbMDonarsCount($estb,$fyid);
        if($totalmaledonars == null)
        {
            return $totalmaledonars = 0;
        }
        else
        {
            return $totalmaledonars->Maledonars;
        }
                
    }
     public function countFemaleDonar($estb,$fyid)
    {
        //$fyid = Session::get('fyindex');
        $totalFemaledonars= donar::getEstbFDonarsCount($estb,$fyid);
        if($totalFemaledonars == null)
        {
            return $totalFemaledonars = 0;
        }
        else
        {
            return $totalFemaledonars->Femaledonars;
        } 
                
    }
    public function AllEstbCollection()
    {
        $fyid = Session::get('fyindex');
        $estblist=  donar::getEstbCollection($fyid);
        $data=[
            'estbBook'=>$estblist,
            'fy'=>session::get('FyTitle')
            
        ];
        return view('dbReports/AllEstbCollection',with($data));
    }
    //PDF download of full year collection
    public function DownloadFyEstbCollectionPDF($estb)
    {
      $fyid = Session::get('fyindex');
      $fyperiod = session::get('FyTitle');
      return  $this->convert2Pdf($this->ConvertReceiptBookHTML($estb,$fyid,$fyperiod),$estb.'-'.date('dmY'));
        
    } 
   
    public function ConvertReceiptBookHTML($estb,$fyid,$title)
    {
        
        $DonarsListofCurrentFY = donar::getDonarsListByEstb($estb, $fyid);
        $output ='<main><h4 align="center">Donars Report of '.$title.'/'.$estb.'</h4>';   
         $output.='<ul style="font-size:11px">
                  <li>Male donors : '.$this->countMaleDonar($estb,$fyid).'</li>
                  <li>Female donors :'.$this->countFemaleDonar($estb,$fyid).'</li>
                  <li>Total Donars : '.$this->getEstbDonarsCount($estb,$fyid).'</li>
                 </ul>';
        $output .='<ul style="border-style:dotted;font-size:11px;font-family: DejaVu Sans; sans-serif;">                   
                   <li>Collection from male donors : &#8377;'.$this->getEstbMDonarsCollection($estb,$fyid).'&nbsp;&nbsp;<small>('.$this->Num2Word($this->getEstbMDonarsCollection($estb,$fyid)).')</small></li>
                   <li>Collection from Female donors :  &#8377;'.$this->getEstbFDonarsCollection($estb,$fyid).'&nbsp;&nbsp;<small>('.$this->Num2Word($this->getEstbFDonarsCollection($estb,$fyid)).')</small></li>
                   <li>Total Collection :  &#8377;'.$this->getEstbDonarsCollection($estb,$fyid).'&nbsp;&nbsp;<small>('.$this->Num2Word($this->getEstbDonarsCollection($estb,$fyid)).')</small></li>
                   </ul>';
        $output .= '<table width="100%" style="border-collapse:collapse; border:0px;font-size:13px">'
                . '<tr>
                   <th style="border:1px solid;  width:20%">Reciept No</th>'
                . '<th style="border:1px solid;  width:20%">Donar Name</th>'
                . '<th style="border:1px solid;  width:20%">Address</th>'
                . '<th style="border:1px solid;  width:20%">Phone</th>'
                . '<th style="border:1px solid;  width:20%">Amount</th>'
                . '<th style="border:1px solid;  width:20%">Pay-mode</th></tr>';
        foreach($DonarsListofCurrentFY as $receiptbookdonars)
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
    //Archives
    public function fyarchives($fyid,$fystart,$fyend)
    {
       //$count = count(donar::getEstbListDonarsCount($fyid));
        $html = "";
        $serial =0;
       $estblist=  donar::getEstbListDonarsCount($fyid);
       
       foreach($estblist as $list)
       {
         $serial++;
         
        $ArrFyStartDate = explode('-',$fystart);
        $ArrFyStartY =$ArrFyStartDate[0];
        $ArrFyEndDate = explode('-',$fyend);
        $varFy = 'FY: '.$ArrFyStartY.'-'.substr($ArrFyEndDate[0],2,2);
        // $varFy = '2020-21';
         $html.= "<br><h3>Establishment ".$serial.".<i><u> ".$list->optionname."</u></i></h3><br>" ;
         $html.="<h4>1. Reciept Book Assignment</h4>";
         $html.=$this->ListofRBbyEstbAndFyid($list->shortname, $fyid);//list of reciept books
         $html.="<div class='page-break'></div>";
         $html.="<h4>2. Reciept Book wise Donars</h4>";
         $html.=$this->ReceiptBookHTML($list->shortname,$fyid);
         $html.="<div class='page-break'></div>";
         $html.="<h4>3. All Donars</h4>";
         $html.= $this->ConvertReceiptBookHTML($list->shortname, $fyid,$varFy);//list of all donars.
         
         
       }
       return $this->convert2Pdf($html,$varFy);
    }
    public function ListofRBbyEstbAndFyid($estb,$fyid)
    {
        $ListofRBbyEstbAndFyid = RecieptBook::getListOfRecieptBookAssignmentsByEstablishmentWise($estb,$fyid);
        $html="<table id='user_table' class='span8 table table-bordered table-striped display-1'>
	<thead>
	  <tr>
	    <th>Book No</th>
            <th>Donee Name </th> 
            <th>Address</th>
            <th>Mobile</th>
	  </tr>
	</thead>
        <tbody>";
        foreach($ListofRBbyEstbAndFyid as $list)
        {
            $html.="<tr><td>".$list->book_no."</td><td>$list->fname $list->mname $list->lname</td><td>$list->address</td><td>$list->mobile</tr>";
        }
        
  $html.="</tbody>
      </table>";
       return $html; 
    }
    public function ReceiptBookHTML($estb,$fyid)
    {
        $AllRecieptBooks=RecieptBook::getListOfRecieptBookAssignmentsByEstablishmentWise($estb,$fyid);
        $output='';
        foreach($AllRecieptBooks as $AssignmentDetail)
        {
        $AssignmentDetail = RecieptBook::getDoneeByAssignmentID($AssignmentDetail->ab_id);
        $receiptbook_data = donar::getDonarsByAssignmentID($AssignmentDetail->ab_id);
        $nolUnused = $AssignmentDetail->nol-$AssignmentDetail->nol_used;
        $fullname=$AssignmentDetail->fname.' '.$AssignmentDetail->mname.' '.$AssignmentDetail->lname;
        $output .='<main><h4 align="center">Donars Detail from Receipt Book No:-'.$AssignmentDetail->book_no.'-'.$AssignmentDetail->bookmode.'</h4>';
        $output .= '<table width="100%" border="1px"style="border-style:dotted;font-size:11px;font-family: DejaVu Sans; sans-serif;">'
                .'<tr><td style="border:0px solid; padding:12px width:50%"><ul><li>Donee:<b>'.$fullname.'</b>('.$this->showDoneeType($AssignmentDetail->donee_type).')</li><li>Issued on:<b>'.date('d-m-Y',strtotime($AssignmentDetail->created_at)).'</b></li><li>Status:<b>'.$this->showAssignmentStatus($AssignmentDetail->status,$AssignmentDetail->updated_at).'</b></li><li>No of leaves Used:<b>'.$AssignmentDetail->nol_used.'</b></li><li>No of leaves Unused:<b>'.$nolUnused.'</b></li></ul></td>'
                . '<td style="border:0px solid; padding:12px width:50%"><ul><li>Total Cash Amount:<b>&#8377; '.donar::TotalDonationReceived($AssignmentDetail->ab_id,"Cash").'</b></li><li>Total Cheque Amount:<b>&#8377; '.donar::TotalDonationReceived($AssignmentDetail->ab_id,"Cheque").'</b></li><li>Total Amount of eTransfers:<b>&#8377; '.donar::TotalDonationReceived($AssignmentDetail->ab_id,"eTransfer").'</b></li><li>No of Leaves Cancelled:<b>'.donar::countDonationReceived($AssignmentDetail->ab_id, "CANCELLED").'</b></li><li>Amount Deposited<b>&#8377; '.donar::TotaldonationDeposited($AssignmentDetail->ab_id).'</b><small>('.$this->Num2Word(donar::TotaldonationDeposited($AssignmentDetail->ab_id)).')</small></li></ul></td></tr>'
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
        
        
        }
        return $output;
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
     public  function showAssignmentStatus($Objstatus,$statusUpdate)
    {
        if($Objstatus==='H'){
          return  $status="Retained";
        }else{
          return $status="Returned on :-".date('d-m-Y',strtotime($statusUpdate));
             }
    }
    public function viewAllBankAccounts()
    {
        
        $bankActlist= bankaccount::getAllAccounts();
        $data=[
            'listofaccounts'=>$bankActlist
                       
        ];
        return view('dbReports/AllBankAccounts',with($data));
    }
    public function ViewAccountDetailByAcid($acid)
    {
        $getAccountDetail = bank::getBankAcountDetail30($acid);
        $expandAcountDetail = bankaccount::expandAccountData($acid);
        $data=[
            'acid'=>$acid,
            'acountdetail'=>$getAccountDetail,
            'expandeddetail'=>$expandAcountDetail
                       
        ];
        return view('dbReports/vewAccountDetailByAcid',with($data));
    }
    public function downloadAccountDetailByAcid($acid)
    {
        return $this->convert2Pdf($this->convertAccountDetailByAcid2HTML($acid),"title");
    }
    
    public function convertAccountDetailByAcid2HTML($acid)
    {
       $expandAcountDetail = bankaccount::expandAccountData($acid);
        $getAccountDetail = bank::getBankAcountDetail($acid);
       $output = '<table width="100%" border="1px"style="border-style:dotted;font-size:11px;font-family: DejaVu Sans; sans-serif;">'
                .'<tr><td style="border:0px solid; padding:12px width:50%"><ul><li>Account Title: <b>'.$expandAcountDetail->title.'</b></li><li>Name of the Bank: <b>'.$expandAcountDetail->bankname.'</b></li><li>Account for Establishment: <b>'.$expandAcountDetail->establishment.'</b></li><li>Purpose of the account: <b>'.$expandAcountDetail->purpose.'</b></li><li>Account Type: <b>'.$expandAcountDetail->atype.'</b></li></ul></td>'
                . '<td style="border:0px solid; padding:12px width:50%"><ul><li>Branch: <b>'.$expandAcountDetail->branch.'</b></li><li>IFSC Code: <b>'.$expandAcountDetail->ifsc.'</b></li><li>Balance: <b>&#8377; '.bank::getLastBalance($acid)->balance.'</b>( <small>'.$this->Num2Word(bank::getLastBalance($acid)->balance).'</small>)</li></ul></td></tr>'
                . '</table><br>';
       $output .= '<table width="100%" style="border-collapse:collapse; border:0px;font-size:13px">'
                . '<tr><th style="border:1px solid; padding:12px width:20%">Date</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Particulars</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Deposits</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Withdrawals</th>'
                . '<th style="border:1px solid; padding:12px width:20%">Balance</th></tr>';
       foreach($getAccountDetail as $data)
        {
            $output.='<tr><td style="border:1px solid; padding:12px">'.date('d-M-Y',  strtotime($data->trnxDate)).'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$data->particulars.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$data->deposits.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$data->withdrawal.'</td>'
                    . '<td style="border:1px solid; padding:12px">'.$data->balance.'</td></tr>';
        }
        $output .= '</table><br><br>';
       return $output;
    }
   
    
}
