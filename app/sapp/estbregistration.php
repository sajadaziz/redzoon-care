<?php

namespace App\sapp;

use Illuminate\Database\Eloquent\Model;
use DB;

class estbregistration extends Model
{
    //
    public  $table = 'estbregistrations';
    
    public static function getEstbRegDetail()
    {
        $getData = DB::table('estbregistrations')
                ->first();
        return $getData;
    }
    public static function checkEstbRegistration()
    {
        $bool = DB::table('estbregistrations')
                ->first();
        return $bool;
    }
    public static function checkEstbRegistration2()
    {
        $bool = DB::table('estbregistrations')
                ->get();
        return $bool;
    }
    
}
