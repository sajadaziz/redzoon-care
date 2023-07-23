<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\assignbook;
use App\donee;
use App\partials\memberstatus;
use App\partials\cheque;
use App\sapp\donar;
use DB;
use App\sapp\optionlabel;
class DonarController extends Controller
{
     public function __construct()
    {
         parent::__construct();
        $this->middleware('auth');
    }
    public function index(){
       if(Session::get('FyStatus')==='A'){
         $bankOptions = optionlabel::getOptionData('Bank');
         $donationOptions = optionlabel::getOptionData('Donation');
            $data = [
                'bankOptions'=>$bankOptions,
                'donationOptions' => $donationOptions
                    ];
            return view('partials/donation',with($data));
       }
        else
        {
            return redirect('home')->with('status',"Access Denied! You are not authorised to access");
        }
    }
    /*function cancelBookLeaf
     * parameter reciept leaf ID
     * return null. this will cancel receipt leaf from the book

     *      */
    public function cancelBookLeaf($donerID)
    {
        donar::cancelBookleaf($donerID);
        return redirect()->back()->with('message','Book leaf cancelled Successfully'); 
    }
     public function getDoneesByBookNo($bookNo)
    {
        //fetch all donee data
        $doneeData['data']= donee::getDoneeByBookNo($bookNo);
        echo json_encode($doneeData);
        exit;
    }
   
    public function Vb_Donee()
    {
        $dbDistrict = DB::table('ref_district')->get()->toArray();
        $data = [
            'dbDistrict' => $dbDistrict,
            'doneetype'=> optionlabel::getOptionData('DoneeType'),
            'doneestatus' => optionlabel::getOptionData('DoneeStatus')
        ];
        return view('partials/collector',with($data));
    }
    public function saveDonee(Request $request)
    {
        $request->validate([
            'txtFname'=>"required|string",
            'txtMname'=>"required|alpha",
            'txtLname'=>"required|alpha",
            'txtMobile'=>"required|numeric|min:11",
            'txtAddress'=>"required|string",
            'doneePic' => 'required|image|mimes:jpeg,png|max:524',
        ]);
        
        $dbdonee = new donee();
        
        $dbdonee->fname = request('txtFname');
        $dbdonee->mname = request('txtMname');
        $dbdonee->lname = request('txtLname');
        $dbdonee->gender = request('gender');
        $dbdonee->m_status = request('mstatus');
        $dbdonee->mobile = request('txtMobile');
        $dbdonee->phone = request('txtLandline');
        $dbdonee->email = request('txtemail');
        $dbdonee->address = request('txtAddress');
        $dbdonee->district = request('optDistrict');
        $imageName = date('dmYhis').'.'.request('doneePic')->getClientOriginalExtension();
        request('doneePic')->move(public_path('images/app-img'), $imageName);
        $dbdonee->doneePic = $imageName;
        try{
        $dbdonee->save();
        $id = $dbdonee->id;
        $this->creatememberstatus($id);
        }
        catch(Throwable $e)
        {
           report($e);
            return FALSE;
           
        }
        
        return redirect()->back()->with('message','Saved Successfully user ID is :'.$id);
    }
    public function creatememberstatus($getID)
    {
        $dbmemberstatus = new memberstatus();        
        $dbmemberstatus->donee_id_fk = $getID;
        $dbmemberstatus->donee_type = request('optDoneeType');
        $dbmemberstatus->status = request('optStatus');
        $dbmemberstatus->s_from = date('Y-m-d',strtotime(request('dpSince'))); 
        
        $dbmemberstatus->save();
    }
    public function SaveDonation(Request $request)
    {
        $request->validate([
           "txtRecieptNo"=>"required|numeric",
           "txtDonarName"=>"required|string",
           "txtAddress"=>"required|string",
           "txtAmount"=>"required|numeric",
            "dpDate"=>"required"
            
        ]);
        if(request('optAmtType')==='By Cheque')
        {
            $request->validate(["txtcheque"=>"required|numeric"]);
        }
        try{
        $dbdonar= new donar();
        $dbdonar->fy_id = Session::get('fyindex');//financial id
        $dbdonar->ab_id= request('abid');//Assignment ID 
        $dbdonar->drname=  request('txtDonarName');
        $dbdonar->draddress=request('txtAddress');
        $dbdonar->drRno=request('txtRecieptNo');
        $dbdonar->drRdate=date('Y-m-d',strtotime(request('dpDate')));
        $dbdonar->drGender=request('optGender');
        $dbdonar->drmobile=request('txtMobileNo');
        $dbdonar->drDtype=request('optDonationType');
        $dbdonar->drAmtype=request('optAmtType');
        $dbdonar->drAmount=request('txtAmount');
        
        $dbdonar->save();
        $getDrid = $dbdonar->id;
        if(request('optAmtType')=='By Cheque')
        {
          $this->newcheque($getDrid);   
          
        }
        assignbook::updateNolUsed(request('abid'));
        return redirect()->back()->with('message','Saved Successfully');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
                    
            return redirect()->back()->with('message',$e->getMessage());
        }
        
    }
    function newcheque($donarid)
    {
          $dbcheque = new cheque();
          $dbcheque->dr_id = $donarid;
          $dbcheque->chqnum = request('txtcheque');
          $dbcheque->drawebank = request('optBank');
          $dbcheque->save();           
    }
}
