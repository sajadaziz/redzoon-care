<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
   public $table = "banks";
   
   public static function getLastBalance($acid)
   {
       $getBal = DB::table('banks')
               ->select('balance')
               ->where('acId',$acid)
               ->orderBy('trnxId','DESC')
               ->take(1)
               ->first();
       return $getBal;
               
   }
   public static function getBankAcountDetail30($acid)
   {
       $data = DB::table('banks')
               ->where('acid',$acid)
               ->orderBy('trnxId','DESC')
               ->take(30)
               ->get();
       return $data;
   }
   public static function getBankAcountDetail($acid)
   {
       $data = DB::table('banks')
               ->where('acid',$acid)
               ->orderBy('trnxId','ASC')
               ->get();
       return $data;
   }
}
