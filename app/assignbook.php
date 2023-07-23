<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;


class assignbook extends Model
{
    protected $table = 'assignbooks';
    
    public static function updateNolUsed($assignmentID)
    {
        $gdata= DB::table('assignbooks')
                ->where('ab_id',$assignmentID)
                ->first();
        $val= $gdata->nol_used+1;
                
       $udata= DB::table('assignbooks')
                ->where('ab_id',$assignmentID)
                ->update(['nol_used'=>$val,
                          'updated_at'=> date('y-m-d')]);
       return $udata; 
    }
    public static function updateStatus($assignmentID)
    {
        $udata= DB::table('assignbooks')
                ->where('ab_id',$assignmentID)
                ->update(['status'=>'R',
                          'updated_at'=> date('y-m-d')]);
       return $udata;
    }
    public static function checkArbStatus()
    {
      $ArbStatus = DB::table('assignbooks')
              ->where('status','=','H')
              ->exists();
      return $ArbStatus;
    }
}
