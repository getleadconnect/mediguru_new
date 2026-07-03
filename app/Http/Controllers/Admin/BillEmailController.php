<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;

use Validator;
use Session;
use App\Models\Promocode;
use App\Models\EbookTitle;
use App\Models\User;
use App\Mail\PurchaseBill;
use DataTables;
use Mail;

class BillEmailController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
    
  public function index()
  {
	 return view('admin.bill_email_template.purchase_bill_template'); 
  }
  
  /*public function send_bill_to_mail()
  {
	$email="shajipr21@gmail.com";
	$data="";
	try
	{
	   Mail::to($email)->send(new \App\Mail\PurchaseBill($data));
	   echo "Mail sent.";
	}
	catch(\Exception $e)
	{
		\Log::info($e->getMessage());
	} 
	
  }*/


  public function send_bill_to_mail()
    {
        $data["user"] = "Shaji";
		$data["email"] = "shajipr21@gmail.com";
        $data["title"] = "Purchase bill from Mediguru";
        $data["body"] = "This is test mail with pdf attachment";
		 
        $data['file'] =public_path('uploads/payment_bills/a1.pdf');
          
		Mail::to($data['email'])->send(new \App\Mail\PurchaseBill($data));
       
        echo "Mail send successfully !!";
		
    }
  
    
	/*
	Mail::send('frontend.password-reset-template', $data, function($message) use ($data) {
                $message->to($data['email'])
                ->subject($data['subject']);
              });
			  
	*/
	
	
	
}

