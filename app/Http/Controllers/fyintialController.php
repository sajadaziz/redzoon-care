<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\partials\Fyintialise;
use Illuminate\Support\Facades\Session;
use App\sapp\donar;
use App\assignbook;

class fyintialController extends Controller
{
    public function __construct() {
        parent::__construct();
    }
    public function index()
    {
        $fyid = Session::get('fyindex');
        $totDoners = donar::getDonarsCount($fyid);
        $totCol=  donar::getSumofAmount($fyid);
        $closedFy = Fyintialise::ClosedFyintials();
        
        $data=[
            'totDoners' => $totDoners,
            'totCollection'=>$totCol,
            'closedFy'=>$closedFy,
            'flag' => Session::get('FyStatus')
              ];
        
        return view('AppSettings/Fyintialisation',with($data));
    }
    
    public function  fyintialisation(Request $request)
    {
        $request->validate([
            'Fy-Starts'=>'required|date_format:d/m/Y',
            'Fy-Ends'=>'required|date_format:d/m/Y'    
        ]);
        $parseFyEnds = strtr(request('Fy-Ends'), '/', '-');
        $parseFyStarts = strtr(request('Fy-Starts'),'/','-');
        $objFyintial = new fyintialise();
        $objFyintial->fyStart = date('Y-m-d',strtotime($parseFyStarts));
        $objFyintial->fyEnd = date('Y-m-d',strtotime($parseFyEnds));
        $objFyintial->status = 'A';
        $objFyintial->save();
        return redirect()->back()->with('message','Saved Successfully');
                
    }
    public function closeAndArchiveFY(Request $request)
    {
       
        $request->validate([
            'Fy-remarks'=>"string"
        ]);
        $data = [
                   'totCollection' => request('Fy-totCollection'),
                   'totDonars' => request('Fy-totDonars'),
                   'totDisburse' => request('Fy-totBenificiaries'),
                   'totBenificiary' => request('Fy-totDisbursment'),
                   'remarks'  => request('Fy-remarks'),
                   'updated_at' => date('y-m-d h:m:s'),
                   'status' => 'C'//financial year closed = 'C' Active = 'A'
        ];
        $fyid = Session::get('fyindex');
        if(!assignbook::checkArbStatus())
        {
        fyintialise::closeFy($fyid,$data);//check if reciept book status is not H 
        $request->session()->flash('FyStatus');
        return redirect()->back()->with('message','Current Financial Year Closed and Archived.To continue, Intialise new Financial Year');
        }
        else
        {
      return redirect()->back()->with('message','Financial Year Not Closed. Please Recieve All allocated RecieptBooks issued during current Financial year');
            
        }
    }
}
