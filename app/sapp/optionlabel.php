<?php

namespace App\sapp;
use DB;
use Illuminate\Database\Eloquent\Model;

class optionlabel extends Model
{
    public $table = "optionlabels";
    
    /* function name: getOptionData
     * param : $type
     * return : all optionname based on parameter type.
     */
    public static function getOptionData($type)
    {
               $value=DB::table('optionlabels')
                    ->where('optiontype',$type)
                    ->get();
        
        return $value;
    }
    
}
