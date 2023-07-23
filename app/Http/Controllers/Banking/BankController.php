<?php

namespace App\Http\Controllers\Banking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\sapp\optionlabel;
use App\bankaccount;
use App\bank;


class BankController extends Controller
{
     public function __construct()
    {
         parent::__construct();
        $this->middleware('auth');
    }
    public function index()
    {
        $AccountNo= "BankAccount";
        $EstbBooks = "EstbBook";
        $BankAccount = bankaccount::getAccountNo();
        $Establishment = optionlabel::getOptionData($EstbBooks);
        $data=[
            'bankAccount' => $BankAccount,
            'estbOptions' => $Establishment
        ];
        return view('Banking/banking')->with($data);
    }
    public function AddBankTrnx(Request $request)
    {
        $request->validate([
            "optBank" => 'required',
            "dpDate" => 'required',
            "optTransactionMethod" => 'required',
            "txtParticulars" => 'required|string|max:100',
            "txtAmount" => 'required|numeric'
         ]);
        $objbankaccount = new bank();
        $objbankaccount->acId = request('optBank');
        $objbankaccount->trnxDate = date('Y-m-d',strtotime(request('dpDate')));
        $objbankaccount->particulars = request('txtParticulars');
        $objbankaccount->TrnxM = request('optTransactionMethod');
        $getBal = $objbankaccount->getLastBalance(request('optBank'));
        if(request('optTransactionMethod')==="Cr"){
       $objbankaccount->deposits = request('txtAmount');
       $objbankaccount->balance = $getBal->balance + request('txtAmount');
       $objbankaccount->save();
       return redirect()->back()->with('message','Bank Transaction Saved Successfully');
 
        }else{
             $objbankaccount->withdrawal = request('txtAmount');
          
             if($getBal->balance !='0.00' && request('txtAmount')<=$getBal->balance)
                 {
                 $objbankaccount->balance =$getBal->balance - request('txtAmount');
                 $objbankaccount->save();
                  return redirect()->back()->with('message','Bank Transaction Saved Successfully');
 
                 }
             else{
                 return redirect()->back()->with('message','Transation truncated,insufficient balance');
                 }
        }
        //select balance from banks where acId = 4 ORDER BY trnxId DESC LIMIT 1;
       
    }
    public function getAllBankData($acid)
    {
        $fetchAccountDetail['data'] = bankaccount::getAllData($acid);
        echo json_encode($fetchAccountDetail);
        exit;
    }
    
}
