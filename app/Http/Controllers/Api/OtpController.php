<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\Tempotp;
use App\User;
use App\Models\OtpApi;

class OtpController extends Controller
{

	public function send_otp(Request $request) // for login
    {

			$api_url=OtpApi::where('status',1)->pluck('api_url')->first();
		
			$mob=$request->mobile;
		
			$otp=mt_rand(1000, 9999);
			
			Tempotp::where('mobile','=',$mob)->delete();
			Tempotp::Create(['mobile' =>$mob, 'otp'=>$otp ]);
			
			$message="Hi, Your OTP to login to MediGuru App is ".$otp." Thankyou Medi-Futura";
	
			//$url="https://app.getlead.co.uk/api/pushsms?username=919746454041&token=gl_109a6b8f8e38faa81268&sender=GLDOTP&to=%mobile%&message=%message%&priority=4&message_type=0";
			
			$url=$api_url;
			
			$url=str_replace("%mobile%",$mob,$url);
			$url=str_replace("%message%",$message,$url);			
			
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
			));

			//Ignore SSL certificate verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

			//get response
			$output = curl_exec($ch);
			$err = curl_error($ch);
			
			curl_close($ch);
						
			
			$err=1;
									
			if ($err)
			{
				$response = [ 'status'=>TRUE,'message'=>"Otp successfully send."];
				
			} else {
				$response = [ 'status'=>FALSE,'message'=>"Failed."   ];
			}
			

		return response($response, 200);
    }
	
	
	public function verify_otp(Request $request)
    {
    	
		$usr_otp=$request->otp;
		$mobile=$request->mobile;
		
		$dt=Tempotp::where('mobile',$mobile)->get()->first();
		
		if($dt->otp==$usr_otp)
		{
			$cm = Tempotp::where('mobile',$mobile)->delete();	
			
			$response = [ 'status'=>TRUE,'message'=>"Otp verification success."   ];
		}
		else {
    		$response = [ 'status'=>FALSE,'message'=>"Incorrect Otp."   ];
    	}
		
		return response($response, 200);
    }
	
   
}