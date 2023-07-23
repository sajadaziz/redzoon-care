<?php

namespace App\partials;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fyintialise extends Model
{
    //
    
    protected $table = 'fyintials';
    
    public static function retriveFyintials(){
        $fydata=DB::table('fyintials')
        ->select('fy_id','fyStart','fyEnd')        
        ->where('status','A')
        ->first();        
       return $fydata;
    }
    public static function checkActiveFyExists()
    {
        $flag = DB::table('fyintials')
                ->where('status','A')
                ->exists();
        return $flag;
    }
    public static function closeFy($fyid,$data)
    {
        $fydata= DB::table('fyintials')
               ->where('fy_id',$fyid)
               ->update($data);
        return $fydata;
    }
    public static function ClosedFyintials(){
        $fydata=DB::table('fyintials')      
        ->where('status','C')
        ->orderBy('fy_id','desc')        
        ->get();        
       return $fydata;
    }
}
