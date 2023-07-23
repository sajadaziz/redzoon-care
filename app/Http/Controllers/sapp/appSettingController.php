<?php

namespace App\Http\Controllers\sapp;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\sapp\optionlabel;
use App\sapp\estbregistration;
use App\bankaccount;

class appSettingController extends Controller
{
    public function __construct() {
    parent::__construct();
    }
    public function index()
    {
        $getBankData= optionlabel::getOptionData('Bank');
        $getAccountPurpose= optionlabel::getOptionData('BankAccount');
        $getEstablishment= optionlabel::getOptionData('EstbBook');
        $data = [
            'optBankName'=>$getBankData,
            'optAccountPurpose'=>$getAccountPurpose,
            'optEstbBook'=>$getEstablishment
        ];
       
        return view('AppSettings/SetOrgSection')->with($data);
    }
    public function addoptions(Request $request)
    {
        $request->validate([
            'txtOptionName'=>"required|string",
            'txtOptionShortName'=>"required|string|max:6",
          ]);
        
        $objOptionLabels = new optionlabel();
        $objOptionLabels->optiontype = request('optOptionType');
        $objOptionLabels->optionname = request('txtOptionName');
        $objOptionLabels->shortname = trim(strtoupper(request('txtOptionShortName')));
        $objOptionLabels->show = "Y";
        try{
        $objOptionLabels->save();
           }
        catch(Throwable $e)
        {
           report($e);
          return FALSE;
           
        }
        
        return redirect()->back()->with('message','Option added Succesfully in '.request('optOptionType'));
    
    }
     public function getOption($type)
    {
        //fetch all donee data
        $optionData['data']= optionlabel::getOptionData($type);
        echo json_encode($optionData);
        exit;
    }
    public function checkRegistration()
    {
        $checkRegistration['data'] = estbregistration::checkEstbRegistration();
        echo json_encode($checkRegistration);
        exit;
                
    }
    public function uploadlogo()
    {
        request()->validate([
            'logo-image' =>'required|image|mimes:jpeg|max:524',
        ]);
          $imageName = request('optEstbBook').'.'.request()->filelogo->getClientOriginalExtension();
          request()->filelogo->move(public_path('images/app-img'), $imageName);
          return back()
            ->with('message','You have successfully uploaded '.$imageName);
            
        
    }
    public function deleteimage($filename)
    {
        $image_path = public_path('images/app-img/'.$filename.'jpeg');
        if(File::exists($image_path)){
            File::delete($image_path);
        }
    }
    public function saveEstbRegistration(Request $request)
    {
        $request->validate([
          'txtEstbName'=>'required|string|max:100',
          'txtMobile'=>'required|numeric',
          'txtAddress'=>'required|string|max:150',
          'logoimage' => 'required|image|mimes:jpeg,png|max:524',
          'txtReg' => 'required|string',
        ]);
        $objEstbRegistration = new estbregistration();
        $objEstbRegistration->estbname =request('txtEstbName');
        $objEstbRegistration->mobile = request('txtMobile');
        $objEstbRegistration->phone =  request('txtLandline');
        $objEstbRegistration->email = request('txtemail');
        $objEstbRegistration->url = request('txturl');
        $objEstbRegistration->address = request('txtAddress');
        $imageName = date('dmYhis').'.'.request('logoimage')->getClientOriginalExtension();
        $objEstbRegistration->logo = $imageName;
        if($this->checkRegistrationKey(request('txtReg'))){
            $objEstbRegistration->register = 1;
            $objEstbRegistration->save();
            request('logoimage')->move(public_path('images/app-img'), $imageName);
            return redirect()->back()->with('message', ' Registered Succesfully in Sakhawat App');
        }
 else {
        return redirect()->back()->with('message','Registration Failed.');
      }
 }
 function savebankaccounts(Request $request)
 {
     $request->validate([
          'optBankName'=>'required',
          'txtAccountNo'=>'required|numeric|min:20',
          'txtIfscCode'=>'string|max:10',
          'txtBranch'=>'required|string|max:100',
          'txtAccountTitle' => 'required|string',
          'optAccountPurpose' => 'required',
          'optEstablishment'=> 'required',
        ]); 
     $objbankAccount = new bankaccount();
     $objbankAccount->bankid = request('optBankName');
     $objbankAccount->estbid = request('optEstablishment');
     $objbankAccount->aptypeid = request('optAccountPurpose');
     $objbankAccount->actno = request('txtAccountNo');
     $objbankAccount->ifsc = request('txtIfscCode');
     $objbankAccount->branch = request('txtBranch');
     $objbankAccount->title = request('txtAccountTitle');
     $objbankAccount->atype = request('optAccountType');
     $objbankAccount->save();
     return redirect()->back()->with('message','Bank Account Details Saved.');
     
 }
    function checkRegistrationKey($key)
    {
        $PrivateKey = 'S990$-A666#-W2310';
        if($key===$PrivateKey)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
}
