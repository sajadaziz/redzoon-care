<?php

namespace App\sapp;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class donar extends Model
{
    //
    public $table = 'donars';
    public static function getSumofAmount($fyid)
    {
       $cdata=DB::table('donars')
               ->where('fy_id',$fyid)
               ->where ('drAmtype','!=','CANCELLED')
               ->sum('drAmount');
               
       return $cdata;
    }
    
    public static function  getDonarsCount($fyid)
    {
        $cdata = DB::table('donars')
                ->where ('fy_id',$fyid)
                ->where ('drAmtype','!=','CANCELLED')
                ->count();
        return $cdata;
    }    
 
    /* function  getDonarsByAssignmentID
     * Parameter Assignment ID
     * Return List of Donars based on Assignment ID
     */
    public static function getDonarsByAssignmentID($assignmentId)
    {
        $cdata = DB::table('donars')
                ->where('ab_id',$assignmentId)
                ->get();
        return $cdata;
    }  
     /*function cancelBookLeaf
     * parameter doner ID
     * return null. this will cancel receipt leaf from the book

     *      */
    public static function cancelBookleaf($donerID)
    {
        $udata= DB::table('donars')
                ->where('dr_id',$donerID)
                ->update(['drAmtype'=>'CANCELLED',
                          'updated_at'=> date('y-m-d h:m:s')]);
       return $udata;
    }
    /* function total-donation-received
     * parameter ab_id,amount type filter
     * return sum of cash based on filter
     */
    public static function TotalDonationReceived($ab_id,$drAmtype)
    {
        $sum = DB::table('donars')
                ->where('ab_id',$ab_id)
                ->where('drAmtype',$drAmtype)
                ->sum('drAmount');
        return $sum;
    }
    /* function countDonationReceived
     * parameter ab_id,amount type filter
     * return sum of cash based on filter
     */
    public static function countDonationReceived($ab_id,$drAmtype)
    {
        $count = DB::table('donars')
                ->where('ab_id',$ab_id)
                ->where('drAmtype',$drAmtype)
                ->count('drAmount');
        return $count;
    }
     /* function TotaldonationDeposited
     * parameter ab_id
     * return total cash deposited by donee.
     */
    public static function TotaldonationDeposited($ab_id)
    {
         $cdata=DB::table('donars')
               ->where('ab_id',$ab_id)
               ->where ('drAmtype','!=','CANCELLED')
               ->sum('drAmount');
         return $cdata;
    }
    /*SELECT AB.ab_id,AB.donee_id,AB.rb_id,D.drname,RB.book_no 
     from assignbooks as AB,donars as D, recieptbooks as RB
      where RB.bookmode = 'SCJK' and AB.rb_id = RB.id and D.ab_id = AB.ab_id
     */
    
    /* function donationDepositedinEstbBook  
     * parameter $estbbook 
     * return total cash deposited in particular establishment by all donees.
     */
    public static function donationDepositedinEstbBook($estbbook)
    {
         $cdata=DB::table('donars')
               ->where('bookmode',$estbbook)
               ->where ('drAmtype','!=','CANCELLED')
               ->sum('drAmount');
         return $cdata;
    }
     /* function name: getEstbBookName
     * param : none
     * return : all available books in App with total donation reiceved.
      * mysql querey:
      * SELECT op.optionname as book, SUM(D.dramount) as TotalDonars
        from assignbooks as AB,donars as D, recieptbooks as RB, optionlabels as op
        where op.shortname = RB.bookmode and AB.rb_id = RB.id and D.ab_id = AB.ab_id and D.drAmtype != 'CANCELLED' GROUP by RB.bookmode
     */
         //LOOP ALL ESTABLISHMENT WITH RESPECTIVE DONARS COLLECTION IN CURRENT FY.
        //RETURNS ALL ESTABLISHMENT WITH TOTAL COLLECTION
    public static function getEstbCollection($fyid)
    {
            $value=DB::table('optionlabels')
                    ->join('recieptbooks','optionlabels.shortname','=','recieptbooks.bookmode')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select('optionlabels.optionname',DB::raw('SUM(donars.dramount) as TotalDonation'),'optionlabels.shortname')
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('donars.fy_id','=',$fyid)
                    ->groupBy('optionlabels.optionname','optionlabels.shortname')
                    ->get();
        
        return $value;
    }
     /*List all  NAME ADDRESS AMOUNT OF donars DURING current fY of selected establishment*/
    public static function getDonarsListByEstb($estb,$fyid)
    {
         $value=DB::table('recieptbooks')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select('donars.drname','donars.drRno','donars.draddress','donars.drAmount','donars.drAmtype','donars.drmobile')
                    ->where('recieptbooks.bookmode','=',$estb)
                    ->where('donars.fy_id','=',$fyid)
                    ->get();
        
        return $value;
    }
    //RETURN TOTAL COLLECTION BY BOTH DONARS(MALE AND FEMALE) IN CURRENT FY AND SELECTED ESTABLISHMENT
    public static function getCollectionbyEstb($estb,$fyid)
    {
          $value=DB::table('recieptbooks')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select(DB::raw('SUM(donars.dramount) as TotalDonation'))
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('recieptbooks.bookmode','=',$estb)
                    ->where('donars.fy_id','=',$fyid)
                    ->first();
        
        return $value;
    }
   
//RETURN TOTAL COLLECTION BY MALE DONARS IN SELECTED ESTABLISHMNET AND CURRENT FY.
    public static function getMCollectionbyEstb($estb,$fyid)
    {
         $value=DB::table('recieptbooks')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select(DB::raw('SUM(donars.dramount) as  MaleDonation'))
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('recieptbooks.bookmode','=',$estb)
                    ->where('donars.fy_id','=',$fyid)
                    ->where('donars.drGender','=','M')
                    ->first();
        
        return $value;
    }
    
    //RETURN TOTAL COLLECTION BY FEMALE DONARS IN SELECTED ESTABLISHMNET AND CURRENT FY.
     public static function getFCollectionbyEstb($estb,$fyid)
    {
         $value=DB::table('recieptbooks')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select(DB::raw('SUM(donars.dramount) as FemaleDonation'))
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('donars.fy_id','=',$fyid)
                    ->where('donars.drGender','=','F')
                    ->where('recieptbooks.bookmode','=',$estb)
                    ->first();
        
        return $value;
       
                   
    }
    
    //LOOP ALL ESTABLISHMENT WITH RESPECTIVE DONARS COUNT IN CURRENT FY.
    //RETURNS ALL ESTABLISHMENT WITH TOTAL DONARS
    public static function getEstbListDonarsCount($fyid)
    {
        $value=DB::table('optionlabels')
                    ->join('recieptbooks','optionlabels.shortname','=','recieptbooks.bookmode')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select('optionlabels.optionname',DB::raw('COUNT(donars.dr_id) as TotalDonars'),'optionlabels.shortname')
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('donars.fy_id','=',$fyid)
                    ->groupBy('optionlabels.optionname','optionlabels.shortname')
                    ->get();
        
        return $value;
    }
    //GET TOTAL  DONARS FROM SELECTED ESTABLISHMENT IN CURRENT FY.
    public static function getEstbDonarsCount($estb,$fyid)
    {
       $value=DB::table('recieptbooks')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select(DB::raw('COUNT(donars.dr_id) as getEstbDonarsCount'))
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('donars.fy_id','=',$fyid)
                    ->where('recieptbooks.bookmode','=',$estb)
                    ->first();
        
        return $value;
    }
    //GET TOTAL MALE DONARS FROM SELECTED ESTABLISHMENT IN CURRENT FY.
     public static function getEstbMDonarsCount($estb,$fyid)
    {
        $value=DB::table('recieptbooks')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select(DB::raw('COUNT(donars.dr_id) as Maledonars'))
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('donars.fy_id','=',$fyid)
                    ->where('donars.drGender','=','M')
                    ->where('recieptbooks.bookmode','=',$estb)
                    ->first();     
        return $value;
    }
    
    //GET TOTAL FEMALE DONARS FROM SELECTED ESTABLISHMENT IN CURRENT FY.
   public static function getEstbFDonarsCount($estb,$fyid)
    {
       $value=DB::table('recieptbooks')
                    ->join('assignbooks','assignbooks.rb_id','=','recieptbooks.id')
                    ->join('donars','donars.ab_id','=','assignbooks.ab_id')
                    ->select(DB::raw('COUNT(donars.dr_id) as Femaledonars'))
                    ->where ('donars.drAmtype','!=','CANCELLED')
                    ->where('donars.fy_id','=',$fyid)
                    ->where('donars.drGender','=','F')
                    ->where('recieptbooks.bookmode','=',$estb)
                    ->first();     
        return $value;
       
    }
}
