<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Str;
use Razorpay\Api\Api;

use App\Models\Course;
use App\Models\Subject;
use App\Models\PurchasedPackage;
use App\Models\PackagePayment;
use App\Models\Package;
use App\Models\Promocode;
use App\Models\Staff;
use App\Models\User;
use App\Models\Student;
use App\Models\PaymentBill;

use App\Mail\PurchaseBill;
use Mail;
use PDF;
use DB;

class PackageController extends Controller
{
	
    /**
	 * Function get_purchased_subjects
	 * Function to get purchased subjects list
	 * Method:POST
	 * @param: student_id=1
	 * return [ subjects ]
	 */
	
  public function get_purchased_subjects(Request $request) 
	{
		
		$stid=$request->student_id;
		//$crsid=$request->course_unique_id;
		
		$ppkgs = PurchasedPackage::select('package_id','packages.course_unique_id','packages.subject_id','packages.package_type')
		->Join('packages','purchased_packages.package_id','=','packages.id')
		->where('purchased_packages.student_id',$stid)->where('packages.status',1)
		->whereDate('packages.expiry_date','>',date('Y-m-d'))
		->orderBy('purchased_packages.id','ASC')->get();
				
		$st_pkgs=[];
		$pkg=[];
		
		if(!$ppkgs->isEmpty())
		{
			foreach($ppkgs as $r)
			{
				if($r->package_type==1)
				{
					$pkg=Subject::select('course_unique_id','id as subject_id')->where('course_unique_id',$r->course_unique_id)->get()->toArray();
					$st_pkgs=array_merge($st_pkgs,$pkg);
				}
				else
				{
					$pkg[0]['course_unique_id']=$r->course_unique_id;
					$pkg[0]['subject_id']=$r->subject_id;
					$x++;
					$st_pkgs=array_merge($st_pkgs,$pkg);
				}
				
			}

			$response = [
			  'status'=>TRUE,
			  'packages'=>$st_pkgs,
			];
		
		}
		else 
		{
			//packages not found-------------------
			
			$st_pkgs[0]['course_unique_id']=null;
			$st_pkgs[0]['subject_id']=null;
			$response = ['status'=>FALSE,'packages'=>$st_pkgs];
		}

		return response($response, 200);
    }
		
	 /**
	 * Function get_purchased_packages
	 * Function to get the student purchased packages
	 * Method:post
	 * @param: student_id
	 * return [ packages ]
	 */

   public function get_purchased_packages(Request $request) 
	{
		$stid=$request->student_id;
				
		$ppkgs = PurchasedPackage::select('purchased_packages.package_id','packages.package_type','packages.sel_package_id','courses.id as course_id','courses.course_name')
		->leftJoin('packages','purchased_packages.package_id','=','packages.id')
		->leftJoin('courses','packages.course_id','=','courses.id')
		->where('purchased_packages.student_id',$stid)->get();
			
		$pkgs=array();
		
		foreach($ppkgs as $r)
		{
			if($r->package_type==1)
			{
				$pkg1=$r->package_id;
			}
			else
			{
				$pkg1=$r->sel_package_id;
			}
			$pkg2=explode(",",$pkg1);
			$pkgs=array_merge($pkgs,$pkg2);
		}	

	  if(!empty($pkgs))
		{
			$response = [
				'status'=>TRUE,
				'packages'=>$pkgs,
			];
		}          
		else
		{
		  $response = ['status'=>TRUE,
		  'packages'=>[],
		  "message" => "No data were found."];
		}	
	
		return response($response, 200);
    }
	
	  /**
	 * Function check_package_expiry_status
	 * Function to check and get expired purchased packages
	 * Method:GET
	 * @param: mone
	 * return [ packages ]
	 */
	
	public function check_package_expiry_status(Request $request)  //expired or not
	{
		
		$validator = Validator::make($request->all(), [
			'student_id' => 'required|string', 
		]);
		
		if ($validator->fails())
		{
			return response(['errors'=>'Student id missing.'], 200);
		}

		$where=['student_id'=> $request->student_id];  //username->mobile number
		
        $pkgs = PurchasedPackage::select('purchased_packages.*','packages.package_name','packages.expiry_date')
				->leftJoin('packages','purchased_packages.package_id','=','packages.id')
				->where($where)->where('packages.expiry_date','<',date('Y-m-d'))->get();
					
		$dat=array();
		$res=array();
		
		if(!$pkgs->isEmpty())
		{
			foreach($pkgs as $p)
			{
				$dat['status']=True;
				$dat['package']=$p->package_name;
				$dat['expiry_date']=$p->expiry_date;
				$dat['message']="Package expired.!";
				$res[]=$dat;
			}
			$response = ['status'=>TRUE,'data'=>$res];
		}
		else
		{
			$response = ['status'=>TRUE];
		}
		
	  return response($response, 200);
    }


   /**
	 * Function purchase_package
	 * Function to purchase new Package and set payment details
	 * Method:POST
	 * @param: student_id,package_id,promocode,referral_code
	 * return [ package_id ]
	 */
		
	/*public function purchase_package(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'student_id' => 'required|string', 
			'package_id' => 'required|string', 
		]);
		
		if ($validator->fails())
		{
			return response(["status"=>FALSE,'message'=>'Details missing.'], 200);
		}
		else
		{
			$stid=$request->student_id;
			$pkgid=$request->package_id;

			//for payments --------------------------------
			$pro_code=$request->promocode;
			$pro_amt=$request->promocode_value;
			$ref_code=$request->referral_code;
			$ref_amt=$request->referral_value;
			$pkg_rate=$request->package_rate;
			$net_amt=$request->net_amount;
			$pmt_id=$request->payment_id;
			
			
			$where=['student_id'=>$stid,'package_id'=>$pkgid];
			$rcnt=PurchasedPackage::where($where)->count();
			if($rcnt>0)
			{
				$response = ['status'=>FALSE,'message'=>"Package already purchased."];
			}
			else{

				$pkg=Package::findorfail($pkgid);  //get package
				
				if($pkg)
				{
					$result=PurchasedPackage::create([
						'student_id'=>$stid,
						'package_id'=>$pkgid,
						'package_type'=>$pkg->package_type,
						'promocode'=>$pro_code,
						'promocode_amount'=>$pro_amt,
						'referral_code'=>$ref_code,
						'referral_amount'=>$ref_amt,
						'amount'=>$pkg->rate,
						'net_amount'=>$net_amt,
						'status'=>1
					]);
					
					 $res=PackagePayment::create([
						'payment_id'=>$pmt_id,
						'student_id'=>$stid,
						'package_id'=>$pkgid,
						'promocode'=>$pro_code,
						'promocode_value'=>$pro_amt,
						'referral_code'=>$ref_code,
						'referral_value'=>$ref_amt,
						'package_rate'=>$pkg_rate,
						'net_amount'=>$net_amt,
						'status'=>1
					]);	

					
					$response = ['status'=>TRUE,'message'=>"Purchase Completed.",'package_id'=>$pkgid,];

				}
				else
				{
					$response = ['status'=>FALSE,'message'=>"Package not found."];
				}
			}
	  }
	  return response($response, 200);
	}
	*/


	public function purchase_package(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'student_id' => 'required|string', 
			'course_unique_id' => 'required|string', 
			'package_type' => 'required|string', 
		]);
		
		
		if ($validator->fails())
		{
			return response(["status"=>FALSE,'message'=>'Details missing.'], 200);
		}
		else
		{

			$stid=$request->student_id;
			$cuid=$request->course_unique_id;
			$pktype=$request->package_type;

			//for payments --------------------------------
			$pro_code=$request->promocode;
			$pro_amt=$request->promocode_value;
			$ref_code=$request->referral_code;
			$ref_amt=$request->referral_value;
			$pkg_rate=$request->package_rate;
			$net_amt=$request->net_amount;
			$pmt_id=$request->payment_id;

			$where1=['course_unique_id'=>$cuid,'package_type'=>$pktype];
			$pkg=Package::where($where1)->first();
			
			$pkgid=(!empty($pkg))?$pkg->id:'';
			
			$where=['student_id'=>$stid,'package_id'=>$pkgid];
			$rcnt=PurchasedPackage::where($where)->count();
			if($rcnt>0)
			{
				$response = ['status'=>FALSE,'message'=>"Package already purchased."];
			}
			else{

				if($pkg)
				{
					
					$result=PurchasedPackage::create([
						'student_id'=>$stid,
						'course_unique_id'=>$cuid,
						'package_id'=>$pkgid,
						'package_type'=>$pktype,
						'promocode'=>$pro_code,
						'promocode_amount'=>$pro_amt,
						'referral_code'=>$ref_code,
						'referral_amount'=>$ref_amt,
						'amount'=>$pkg->rate,
						'net_amount'=>$net_amt,
						'status'=>1
					]);
					
					$ppkg_id=$result->id;
										
					$res=PackagePayment::create([
						'payment_id'=>$pmt_id,
						'student_id'=>$stid,
						'course_unique_id'=>$cuid,
						'package_id'=>$pkgid,
						'promocode'=>$pro_code,
						'promocode_value'=>$pro_amt,
						'referral_code'=>$ref_code,
						'referral_value'=>$ref_amt,
						'package_rate'=>$pkg_rate,
						'net_amount'=>$net_amt,
						'status'=>1
					]);	
					
					$capture=$this->payment_capture($request);  //capture razorpay payament
					
										
					$result_pdf=$this->generate_bill_pdf($request);
										
					$res=PaymentBill::create([
						'payment_id'=>$pmt_id,
						'student_id'=>$stid,
						'course_unique_id'=>$cuid,
						'purchased_package_id'=>$ppkg_id,
						'package_id'=>$pkgid,
						'bill_filename'=>$result_pdf,
					]);

					$mail_result=$this->send_bill_to_mail($request,$result_pdf);
				
					$response = ['status'=>TRUE,'message'=>"Purchase Completed.",'package_id'=>$pkgid,];

				}
				else
				{
					$response = ['status'=>FALSE,'message'=>"Package not found."];
				}
			}
	  }
	  
	  return response($response, 200);
	  
	}
		
//------ capture razorpay payments-------------------------------

public function payment_capture($request)
{        
	
	$input = $request->all();
		
	$api = new Api(config('constants.razorpay_key'), config('constants.razorpay_secret'));
	$payment = $api->payment->fetch($input['payment_id']);

	if(count($input) and !empty($input['payment_id'])) 
	{
		try 
		{
			$response = $api->payment->fetch($input['payment_id'])->capture(array('amount'=>$payment['amount'])); 
		} 
		catch (\Exception $e) 
		{
			$response = $e->getMessage();
		}  
	}
	return $response;
}
	
 /**
	 * Function single_purchase_package -- subject package
	 * Function to purchase single subjects and set payment details
	 * Method:POST
	 * @param: student_id,package_id,promocode,referral_code
	 * return [ package_id ]
	 */	
	
public function single_purchase_package(Request $request)
	{
		
		$validator = Validator::make($request->all(), [
			'student_id' => 'required|string', 
			'package_id' => 'required|string',  //eg: 1,2,3
		]);
		
		if ($validator->fails())
		{
			return response(["status"=>FALSE,'message'=>'Details missing.'], 200);
		}
		else
		{
			$stid=$request->student_id;
			$pkgid=$request->package_id;
			$pkg_ids = explode(",",$pkgid);
			
			//for payments --------------------------------
			
			$pro_code=$request->promocode;
			$pro_amt=$request->promocode_value;
			$ref_code=$request->referral_code;
			$ref_amt=$request->referral_value;
			$tot_rate=$request->package_rate;   //total package rate (multiple/single)
			$net_amt=$request->net_amount;
			$pmt_id=$request->payment_id;
						
			$unique_id="";
			
			$data=[];
			$gst=18;
			$tot_disc=0;
			$tot_amount=0;
			$tot_gst=0;
					
			foreach($pkg_ids as $pid)
			{
				$pkg=Package::findorfail($pid);  //get package

				if($pkg)
				{
					$crs=Course::where('unique_id',$pkg->course_unique_id)->first();
					
					$result=PurchasedPackage::create([
						'course_unique_id'=>$pkg->course_unique_id,
						'student_id'=>$stid,
						'package_id'=>$pkg->id,
						//'package_type'=>$pkg->package_type,
						'promocode'=>$pro_code,
						'promocode_amount'=>$pro_amt,
						'referral_code'=>$ref_code,
						'referral_amount'=>$ref_amt,
						'amount'=>$pkg->rate,
						'net_amount'=>$net_amt,
						'status'=>1
					]);
				
					$unique_id=$pkg->course_unique_id;	

					//gst calculation----------------------------
					
						$rate=$pkg->rate;
						$value=round(($rate*$gst/(100+$gst)),2);
						$gst_val=round(($value/2),2);
				
						$dat=[
							'course_name'=>$crs->course_name,
							'package_id'=>$pkg->id,
							'rate'=>$pkg->rate,
							'tax_amt'=>$rate,
							'gst_percentage'=>$gst,
							'gst_val'=>$gst_val,
						 ];
					
					$data[]=$dat;
					
					$tot_amount+=$rate;
					$tot_gst+=$gst_val;
				//---------------------------------------------------
				}
			}

			$data[0]['total_amount']=$tot_amount;
			$data[0]['total_gst']=$tot_gst;
			
			
			if(count($pkg_ids)>0)
			{
			    $res=PackagePayment::create([
					'payment_id'=>$pmt_id,
					'student_id'=>$stid,
					'course_unique_id'=>$unique_id,
					'package_id'=>$pkgid,
					'promocode'=>$pro_code,
					'promocode_value'=>$pro_amt,
					'referral_code'=>$ref_code,
					'referral_value'=>$ref_amt,
					'package_rate'=>$tot_rate,
					'net_amount'=>$net_amt,
					'status'=>1
				]);	
			}
			
			$capture=$this->payment_capture($request);  //capture razorpay payment 

			$result_pdf=$this->generate_subject_bill_pdf($request,$data);			

					$res=PaymentBill::create([
						'payment_id'=>$pmt_id,
						'student_id'=>$stid,
						'course_unique_id'=>$unique_id,
						'purchased_package_id'=>null,
						'package_id'=>$pkgid,
						'bill_filename'=>$result_pdf,
					]);	
			
			
			$mail_result=$this->send_bill_to_mail($request,$result_pdf);
			
			
			$response = ['status'=>TRUE,'message'=>"Purchase Completed.",'package_id'=>$pkgid,];
		}
		
	  return response($response, 200);
	  
	}


//--------------------------------bill pdf -----------------------------------------------------	
		
	public function generate_bill_pdf($request)
    {
		
		$st=Student::whereId($request->student_id)->first();
		$crs=Course::where('unique_id',$request->course_unique_id)->first();
		
		if(!empty($st))
		{
			$stname=$st->name;
			$mob=$st->mobile;
			$email=$st->email;
		}
		else
		{
			$stname="";
			$mob="";
			$email="";
		}
		
		$pdf_name=$request->student_id."_".mt_rand(100,999)."_".date('dmY').".pdf";
		
		$invNo="INV".mt_rand(100,999).date('dmy');
		
		$data = [
            'student_name' => $stname,
            'student_mobile' => $mob,
			'student_email' => $email,
			'invoice_no' => $invNo,
			'pro_code'=>$request->promocode,
			'pro_amt'=>$request->promocode_value,
			'ref_code'=>$request->referral_code,
			'ref_amt'=>$request->referral_value,
			'pkg_rate'=>$request->package_rate,
			'net_amt'=>$request->net_amount,
			'course_name'=>$crs->course_name,
			'gst_percentage'=>18,
        ];
        
		
        $pdf = PDF::loadView('admin.bill_email_template.purchase_bill_template',compact('data'));
		$content = $pdf->download()->getOriginalContent();
		$filename="mediguru/payment_bills/".$pdf_name;
		//Storage::put('payment_bills/'.$filename,$content);
		//$result=Storage::disk('local')->put("payment_bills/".$filename,$content);
		
		$fname ="mediguru/payment_bills/".$pdf_name;
		Storage::disk('spaces')->put("mediguru/payment_bills/".$pdf_name,$content,'public');
		return $fname;
    }
  
      
  //multiple subject purchases-----------------------------------------------------------
  
  public function generate_subject_bill_pdf($request,$data)
    {
		$st=Student::whereId($request->student_id)->first();
				
		if(!empty($st))
		{
			$stname=$st->name;
			$mob=$st->mobile;
			$email=$st->email;
		}
		else
		{
			$stname="";
			$mob="";
			$email="";
		}
		
		$pdf_name=$request->student_id."_".mt_rand(100,999)."_".date('dmY').".pdf";
		
		$invNo="INV".mt_rand(100,999).date('dmy');
		
		$stdata = [
			'student_name' => $stname,
			'student_mobile' => $mob,
			'student_email' => $email,
			'invoice_no' => $invNo,
			'gst_percentage'=>18,
		  ];
        
		
        $pdf = PDF::loadView('admin.bill_email_template.purchase_bill_subject_template',compact('data','stdata'));
		$content = $pdf->download()->getOriginalContent();
		$filename="mediguru/payment_bills/".$pdf_name;
		
		$fname ="mediguru/payment_bills/".$pdf_name;
		Storage::disk('spaces')->put("mediguru/payment_bills/".$pdf_name,$content,'public');
		return $fname;
    }
   
  
  public function send_bill_to_mail($request,$pdf)
    {
		$st=Student::whereId($request->student_id)->first();
		$data=["user"=>'','email'=>''];
		if(!empty($st))
		{
			$data=["user"=> $st->name,
				   "email" => $st->email,
				   "file" =>"https://eayushdata.sgp1.digitaloceanspaces.com/".$pdf
				  ];
          
			try 
			{
				$response=Mail::to($data['email'])->send(new \App\Mail\PurchaseBill($data));
			}
			catch (\Exception $e) 
			{
				$response = $e->getMessage();
			}  
			
			return $response;
		}
		
    }
		

}

