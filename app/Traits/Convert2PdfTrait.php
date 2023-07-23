<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Traits;
use App\sapp\estbregistration;
use pdf;
/**
 * Description of Convert2PdfTrait
 *
 * @author SajadAziz
 */
trait Convert2PdfTrait {
    //put your code here
    
    public static function estbDetails()
      {
         $getestbDetails = estbregistration::getEstbRegDetail();
         return $getestbDetails;
     }
     
    function convert2Pdf($htmlcontents,$title)
    {
        $contents = $this->addStyleToPdf();
        $contents .=$this->PdfHeader($title);
        $contents .= $htmlcontents;
        $contents .=$this->signatory();
        $contents .=$this->PdfFooter();
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($contents);
        $pdf->setPaper('a4');
        return $pdf->stream();
    }
    
    
    function addStyleToPdf()
    {
         $style= ' <style> /** Define the margins of your page **/
     @page { margin: 0cm 0cm;} .pagenum:before {content: counter(page);}
     div.header {position: fixed;top: 0.6cm;left: 1cm;right: 0cm;height: 3cm;}
     .headertext{position: fixed; top: 1.5cm;left: 5cm; righ:0cm;font-size:20px;border-bottom: 1px solid black;
padding-bottom: 5px;}
    
     body {
                margin-top: 3cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }
     .dash{ border: 1px dotted black; bottom: -60px; position: fixed width: 750px; height: 50px;}
     footer {position: fixed; bottom: 0cm; left: 0cm; right: 0cm; height: 2cm; 
              /** Extra personal styles **/
              color: black; font-size:11px; text-align:center;line-height:20px;}
.page-break {
    page-break-after: always;
}              
</style>';
      
       return $style;    
    }
    
    function PdfHeader($title)
    {
        $header = '<title>'.$title.'</title><div class="header"><img src="images/app-img/'.$this->estbDetails()->logo.'" height="80px" width="80px"><b class="headertext">'.$this->estbDetails()->estbname.'</b></div>';
        return $header;
    }
    
    function PdfFooter()
    {
        $footer = '<footer><hr>(Page: <span class="pagenum"></span>)'.$this->estbDetails()->estbname.'&nbsp;Office Address: '.$this->estbDetails()->address.'&nbsp;Mob: '.$this->estbDetails()->mobile.'<br>'.$this->estbDetails()->url.'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->estbDetails()->email.'</footer';
        return $footer;
    }
    
    private  function signatory()
    {
       $signatory =  '<h5 align="right">For '.$this->estbDetails()->estbname.'</h5></main>';
       return $signatory;
    }
}
