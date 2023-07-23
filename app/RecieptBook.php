<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class RecieptBook extends Model
{
   public $table = 'recieptbooks';
   public static function openRbook()
   {
       $dbdata = DB::table('recieptbooks')
                 ->join('assignbooks', 'recieptbooks.id', '=', 'assignbooks.rb_id')
                 ->select('recieptbooks.*','assignbooks.*')
                 ->where('recieptbooks.status','=','O')
                 ->orderBy('recieptbooks.id')
                 ->get();
       return $dbdata;
   }
    public static function DisposedRbook()
   {
       $dbdata = DB::table('recieptbooks')
                 ->join('assignbooks', 'recieptbooks.id', '=', 'assignbooks.rb_id')
                 ->select('recieptbooks.*','assignbooks.donee_id','assignbooks.nol_used')
                 ->where('recieptbooks.status','=','C')
                 ->orderBy('recieptbooks.id','desc')
                 ->get();
       return $dbdata;
   }
   public function updateRbookStatus($bookno)
    {
      
                $user = DB::table('recieptbooks')
                ->where('id',$bookno)
                ->update(['status'=>'A',
                          'updated_at'=> date('y-m-d')]);
        
           
         //$this->save();
    }
    public static function  updateRbookStatus2Open($rbid)
    {
      
                $user = DB::table('recieptbooks')
                ->where('id',$rbid)
                ->update(['status'=>'O',
                          'updated_at'=> date('y-m-d')]);
        
           
         //$this->save();
    }
     /*Function to get count of ReceiptBook 
     * issued during current Financial year
       Argument void
     * Return count     */
    
   public static function getCountOfRecieptBookIssued($fyid)
   {
     $rbCount = DB::table('assignbooks')
             ->where('assignbooks.fy_id', $fyid)
             ->count();
             
     return $rbCount;
   }
    
    /*query to select data from varios tables.
     * SELECT A.ab_id,A.donee_id,A.rb_id,A.fy_id,B.book_no,
     * C.fname,C.mname,C.lname from assignbooks as A,recieptbooks as B, 
     * donees as C where A.donee_id = C.donee_id and A.rb_id = B.id ORDER by B.book_no
        Get list of donees who has been issued reciept books during current Financial year     */
    public function getListOfRecieptBookAssignments()
    {
      $cdata=DB::table('recieptbooks')
        ->join('assignbooks', 'recieptbooks.id', '=', 'assignbooks.rb_id')
        ->join('donees','assignbooks.donee_id','=','donees.donee_id')
        ->select( 'assignbooks.*','donees.*','recieptbooks.book_no')
        ->where('assignbooks.fy_id',Session::get('fyindex'))
        ->get(); //change to first only if you need one record.
       return $cdata;  
    }
    public static function getListOfRecieptBookAssignmentsByEstablishmentWise($estb,$fyid)
    {
      $cdata=DB::table('recieptbooks')
        ->join('assignbooks', 'recieptbooks.id', '=', 'assignbooks.rb_id')
        ->join('donees','assignbooks.donee_id','=','donees.donee_id')
        ->select( 'assignbooks.*','donees.*','recieptbooks.book_no')
        ->where('assignbooks.fy_id',$fyid)
        ->where('recieptbooks.bookmode',$estb)
        ->get(); //change to first only if you need one record.
       return $cdata;  
    }
   /* SELECT AB.ab_id,AB.donee_id,AB.rb_id,D.fname,RB.book_no 
     from assignbooks as AB,donees as D, recieptbooks as RB
      where AB.ab_id = 4 and AB.donee_id = D.donee_id and AB.rb_id = RB.id;
    * Function : getDoneeByAssignmentID
    * Parameter: Assignment ID
    * Return : Detail of Donee Based on Assignemnt ID
    
    */
    public static function getDoneeByAssignmentID($assignmentId)
    {
        $cdata = DB::table('assignbooks')
                ->join('recieptbooks','assignbooks.rb_id','=','recieptbooks.id')
                ->join('donees','assignbooks.donee_id','=','donees.donee_id')
                ->join('memberstatuses','donees.donee_id','=','memberstatuses.donee_id_fk')
                ->select('assignbooks.rb_id','assignbooks.ab_id', 'assignbooks.nol_used','assignbooks.status','assignbooks.created_at','assignbooks.updated_at','donees.fname','donees.mname','donees.lname','donees.doneePic','recieptbooks.book_no','recieptbooks.nol','recieptbooks.bookmode','recieptbooks.status as rbstatus','memberstatuses.donee_type')
                ->where('assignbooks.ab_id',$assignmentId)
                ->first(); //change to first only if you need one record.
        return $cdata;
    }
     public static function updateStatus($rbid)
    {
        $udata= DB::table('recieptbooks')
                ->where('id',$rbid)
                ->update(['status'=>'C',
                          'updated_at'=> date('y-m-d h:m:s')]);
       return $udata;
    }
    
    
}
