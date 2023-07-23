<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Http\Request;
use App\partials\Fyintialise;
use Illuminate\Support\Facades\Session;
use App\sapp\donar;
use App\RecieptBook;
use App\donee;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $objFy;
    public $abc;
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->objFy = new Fyintialise();
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->is_admin==1){
        
        $FyData =$this->objFy->retriveFyintials();
        if(isset($FyData)){
        Session::put('fyindex',$FyData->fy_id);
        $fyid = $FyData->fy_id;
        $ArrFyStartDate = explode('-',$FyData->fyStart);
        $ArrFyStartY =$ArrFyStartDate[0];
        $ArrFyEndDate = explode('-',$FyData->fyEnd);
        $varFy = 'FY: '.$ArrFyStartY.'-'.substr($ArrFyEndDate[0],2,2);
        Session::put('FyTitle',$varFy);
        $FyStatus = 'A';//financial year is set and active
        Session::put('FyStatus',$FyStatus);
        }
        else
        {
            Session::put('fyindex',0);
            Session::put('FyTitle','Financial Year Not Set');
            $varFy = 'Financial Year Not Set';
            $fyid = 0;
            $FyStatus = 'C';//financial year is closed and new financial year not intialised
            Session::put('FyStatus',$FyStatus);
        }
        
        $countRbooks = RecieptBook::getCountOfRecieptBookIssued($fyid);
        $countDonees = donee::getCountOfdonees();
        $totalamount = donar::getSumofAmount($fyid);
        $totalDonars = donar::getDonarsCount($fyid);
       
       
        
        $data = [
            'countRbooks' => $countRbooks,
            'countDonees' => $countDonees,
            'totalamount' => number_format($totalamount,2),
            'countDoners' => $totalDonars,
            'getsess' => Session::get('fyindex'),
            'varFY'=>$varFy
            
            ];
        return view('adminhome',with($data));
        

        }
        else
        {
        $FyData =$this->objFy->retriveFyintials();
        Session::put('fyindex',$FyData->fy_id);
        $ArrFyStartDate = explode('-',$FyData->fyStart);
        $ArrFyStartY =$ArrFyStartDate[0];
        $ArrFyEndDate = explode('-',$FyData->fyEnd);
        $varFy = 'FY: '.$ArrFyStartY.'-'.substr($ArrFyEndDate[0],2,2);
        $data = [
            'getsess' => Session::get('fyindex'),
            'varFY'=>$varFy
            ];
        
        return view('home',with($data));
        }
    }
    /*public function adminhome()
    {
        return view('adminhome');
    }
    */
    public function donation()
    {
        return view('partials/donation');
    }
    public function userRegistraton()
    {
       return view('partials/user');
    }
    
   
   
}
