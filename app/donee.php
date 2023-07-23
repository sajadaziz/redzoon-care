<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class donee extends Model
{
    //
    protected $table= 'donees';
    
    /* function name: getCountOfdonees
     * parameter void
     * return Number of donees/members 
     */
     public static function getCountOfdonees()
     {
     $dCount = DB::table('donees')
               ->count();
             
     return $dCount;
     }
     
    /* function name: getDoneeData
     * parameter donee id( id of the member / donees )
     * return: complete row of information from database where id matches.
     */ 
    public static function getDoneeData($id)
    {
        if($id==0)
        {
            $value=DB::table('donees')
                    ->orderBy('donee_id','asc')
                    ->get();
        }
        else
        {
          $value=DB::table('donees')
                    ->where('donee_id',$id)
                    ->first();
        }
        return $value;
    }
    
    /*SELECT recieptbooks.id,donees.fname,recieptbooks.book_no,recieptbooks.status from recieptbooks 
        JOIN assignbooks on recieptbooks.id = assignbooks.rb_id 
        JOIN donees on donees.donee_id = assignbooks.donee_id 
        where recieptbooks.book_no = '1234' and recieptbooks.status='A';
     ----------------------------------------------------------
      function: getDoneeByBookNo
     *Parameter: Book No
     * Return : Name, address,phone number of the donee whome this book no(parameter) has been issued
     * 
 *  */
    public static function getDoneeByBookNo($bookNo)
    {
       $cdata=DB::table('recieptbooks')
        ->join('assignbooks', 'recieptbooks.id', '=', 'assignbooks.rb_id')
        ->join('donees','assignbooks.donee_id','=','donees.donee_id')
        ->select( 'assignbooks.*','donees.*','recieptbooks.*')
        ->where('recieptbooks.book_no',$bookNo )
        ->where('recieptbooks.status','A')// second where is equal to AND condtion e.g where a=a AND b=b
        ->first(); //change to first only if you need one record.
       return $cdata;
    }
}
