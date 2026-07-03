<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use PDF;
use Session;

class PDFController extends Controller
{
   
  public function __construct()
  {
      $this->middleware('admin');
  }
    
    public function index()
    {
        		
    }
   
    public function generate_pdf(Request $request)
    {
        $data = [
            'title' => 'Shaji',
            'date' => date('m/d/Y')
        ];
          
        $pdf = PDF::loadView('admin.bill_email_template.purchase_bill_template',compact('data'));
		$content = $pdf->download()->getOriginalContent();
		$filename="a2.pdf";
		//Storage::put('payment_bills/'.$filename,$content);
		$result=Storage::disk('local')->put("payment_bills/".$filename,$content);
		
		return $result;
		
		//$fname1 ="mediguru/video_icons/".$filename;
		//Storage::disk('spaces')->putFileAs("mediguru/payment_bills",$content,$filename, 'public');
		
    }
   
   
}
