<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class bankaccount extends Model
{
    public $table = "bankaccounts";
    
    public static function  getAllData($acid)//get full row based on acid.
    {
        $data = DB::table('bankaccounts')
              ->where('acid',$acid)
              ->first();
        return $data;
    }
     public static function  getAllAccounts()//get All row without filter.
    {
        $data = DB::table('bankaccounts')
              ->get();
        return $data;
    }
    public static function getAccountNo()//retrieve all account numbers
    {
        $data = DB::table('bankaccounts')
                ->select('acid','actno')
                ->get();
        return $data;
    }
    public static function expandAccountData($acid)//expanded full row based on acid.
    {
        $data = DB::table('bankaccounts')
              ->join('optionlabels','bankaccounts.bankid','=','optionlabels.id')
              ->join('optionlabels as A','bankaccounts.estbid','=','A.id')
              ->join('optionlabels as B','bankaccounts.aptypeid','=','B.id')
              ->select('bankaccounts.*','optionlabels.optionname as bankname','A.optionname as establishment','B.optionname as purpose')
              ->where('acid',$acid)
              ->first();
        return $data;
    }
}
