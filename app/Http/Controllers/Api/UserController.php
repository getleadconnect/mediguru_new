<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Student;
use App\Models\RemovedStudent;
use App\Models\ParentUser;
use App\Models\PurchasedPackage;
use App\Models\StudentDevice;

class UserController extends Controller
{

/**
	 * Function login
	 * Function to login students
     * Method : post
     * parameters : mobile,passsword,version_release,manufacturer,model,androidid,brand,device
	 * return [details]
	 */
 
	public function login(Request $request) 
	{
			
		        //status = 1-active, 2-disabled, 3- expired;
			
				$validator = Validator::make($request->all(), [
				  'mobile' => 'required|string',   //mobile no
				  'password' => 'required|string',
				  'version_release'=> 'required',
				  'manufacturer'=> 'required',
				  'model'=> 'required',
				  'androidid'=>'required',
				  'brand'=>'required',
				  'device'=>'required',		
				]);
			
			
				if ($validator->fails())
				{
					return response(['errors'=>'Invalid user details.'],200);
				}
				
				$where=['mobile'=> $request->mobile];
				$user = User::where($where)->first();
				
				$mob=$request->mobile;   //mobile no
							
				if (!empty($user)) 
				{
					$lgcnt=StudentDevice::where('student_id',$user->student_id)->get()->count();
					
					$sddata=['reg_date'=>date('Y-m-d'),
							   'student_id'=> $user->student_id,
							   'student_name'=>$user->name,
							   'mobile'=>$mob,
							   'version_release'=> $request->version_release,
							   'manufacturer'=> $request->manufacturer,
							   'model'=> $request->model,
							   'androidid'=>$request->androidid,
							   'brand'=> $request->brand,
							   'device'=> $request->device,
							   'status'=>'1',
							];
					
					if($lgcnt<=0)
					{
						StudentDevice::create($sddata);
					}
					else
					{
					   $res1=StudentDevice::where('student_id',$user->student_id)->update($sddata);	
					}
							
					$androidid=$request->androidid;

						if($user->status==1)
						{
							if (Hash::check($request->password, $user->password)) 
							{
								Auth::login( $user );
								$token = $user->createToken('becompetitive')->accessToken;
								
								$stdt=Student::whereId($user->student_id)->first();
								if(!empty($stdt))		
								{
									
								$pkg=PurchasedPackage::select('purchased_packages.package_id','packages.package_name','courses.id as course_id','courses.course_name')
									->leftJoin('packages','purchased_packages.package_id','=','packages.id')
									->leftJoin('courses','packages.course_unique_id','=','courses.unique_id')
									->where('purchased_packages.student_id',$user->student_id)->get();
								
								
								     $response = [
										'status'=>TRUE,
										'message'=>"Login Success.",
										'token' => $token,
										'user_id'=> Auth::id(),
										'student_id'=>$user->student_id,
										'student_name'=>$stdt->name,
										'mobile'=>$user->mobile,
										'email'=>$stdt->email,
										'state'=>$stdt->state,
										'student_image'=>$stdt->student_image,
										'image_path'=>config('constants.image_path').$stdt->student_image,
										'package'=>$pkg,   
										'android_ios_id'=>$androidid,
									];

								}
								else
								{
									$response = ['status'=>False, "message" => "Student details not found."];
								}
							}
							else {
							   $response = ['status'=>False, "message" => "Password mismatch."];
							}
						}
						else
						{
							$response = ['status'=>FALSE, "message" =>'Account temporarily disabled.'];
							return response($response, 200);
						}
				} 
				else {
					$response = ['status'=>False, "message" =>'User does not exist'];
				}
		
		return response($response, 200);
		
}


/**
	 * Function register
	 * Function to new student registration
     * Method : post
     * parameters : name,gender,birth_date,mobile,email,state,student_image
	 * return [true/false]
	 */


public function register_student(Request $request)  
{
	$result="";

		$mob_check=Student::where('mobile',trim($request->mobile))->get()->count();
		$ema_check=Student::where('email',trim($request->email))->get()->count();
		
		if($mob_check<=0 and $ema_check<=0)
		{
			
			$fname="";
			if($request->file('student_image'))
			{
				$ext=$request->file('student_image')->getClientOriginalExtension();	 
				$filename = "st_".date('Ymdhis').".".$ext;
				$fname ="mediguru/student_images/".$filename;
				Storage::disk('spaces')->putFileAs("mediguru/student_images",$request->file('student_image'), $filename, 'public');
			}
		
		    $result="";
		
			DB::beginTransaction();
			try{

				$res=Student::create([
					'reg_date'=>date('Y-m-d'),
					'name'=>$request->name,
					'gender'=>$request->gender,
					'date_of_birth'=>date_create($request->birth_date)->format('Y-m-d'),
					'mobile'=>$request->mobile,
					'email'=>$request->email,
					'state'=>$request->state,
					'student_image'=>$fname,
					'status'=>1,
				]);

				 $stid=$res->id;
				//student user

				$result=User::create([
					'student_id'=>$stid,
					'mobile'=>$request->mobile,
					'email'=>$request->email,
					'password'=>Hash::make($request->password),
					'status'=>1
				]);
				
				DB::commit();
				
				if ($result) 
					{
					$response = ['status'=>TRUE,'message'=>"Registration Successfully Completed."];
				}
				else {
					$response = ['status'=>FALSE, "message" => "Something wrong, Please try again."];
				}
				
			}
			catch(\Exception $e)
			{
				DB::rollback();
				$response = ['status'=>FALSE,'message'=>$e->getMessage()];
			}
		}
		else
		{
		   $response = ['status'=>FALSE,'message'=>"Mobile/Email already exisit."];	
		}
	
	return response($response, 200);
}


/**
	 * Function remove_user_account
	 * Function to permanantly remove user account
     * Method : post
     * parameters : mobile
	 * return [true/false]
	 */


public function remove_user_account(Request $request)  
{
	
		$stdt=Student::where('mobile',$request->mobile)->first();
		$st=$stdt;
		
		if(!empty($stdt))
		{
			
			/*if($stdt->student_image!='')
			{
				$fname ="mediguru/".$stdt->student_image;
				Storage::disk('spaces')->delete($fname);
			}*/
			
			$result=User::where('student_id',$stdt->id)->delete();
			$result=$stdt->delete();
			
			if ($result) 
				{
					
				if(!empty($st))
				{
					$res=RemovedStudent::create([
					'student_id'=>$st->id,
					'name'=>$st->name,
					'gender'=>$st->gender,
					'date_of_birth'=>$st->date_of_birth,
					'mobile'=>$st->mobile,
					'email'=>$st->email,
					'state'=>$st->state,
					'student_image'=>$st->student_image,
					'package_status'=>$st->package_status,
					'status'=>1
					]);
				}
	
				$response = ['status'=>TRUE,'message'=>"User account Successfully removed."];
			}
			else {
				$response = ['status'=>FALSE, "message" => "Something wrong, Please try again."];
			}
			
		}
		else
		{
			$response = ['status'=>FALSE, "message" => "No user were found."];
		}
			
	return response($response, 200);
}


/**
	 * Function get_profile
	 * Function to get student details
     * Method : post
     * parameters : student_id
	 * return [true/false]
	 */

public function get_profile(Request $request)  
{
		$stid=$request->student_id;
		
		$stdt=Student::where('id',$stid)->get()->first();
		if(!empty($stdt))
		{
			$response = ['status'=>TRUE,
						 'data'=>$stdt,
						 'image_path'=>config('constants.image_path'),
					    ];
		}
		else
		{
			$response = ['status'=>FALSE,'message'=>"No data were found."];	
		}

	return response($response, 200);
}

/**
	 * Function update_profile
	 * Function to update profile
     * Method : post
     * parameters : student_id,name,gender,birthdate,mobile,email,state,student_image
	 * return [true/false]
 */

public function update_profile(Request $request)  
{
		$status=TRUE;
		$stid=$request->student_id;
		
		$sdt=Student::where('id',$stid)->get()->first();
		
		if(empty($sdt))
		{
			$response = ['status'=>FALSE,'message'=>"Student details not found."];
		}
		else
		{
			if($sdt->mobile!=$request['mobile'])
			{
				$mob_check=Student::where('mobile',$request['mobile'])->get()->count();
				if($mob_check>0)
				{
					$status=FALSE;
				}
				else
				{	
					$status=TRUE;
				}
			}
			else
			{
				$status=TRUE;
			}
		
		//updating data
		
			if($status==TRUE)
			{
					$fname=$sdt->student_image;
					
					if($request->file('student_image'))
					{
						$dat=Student::find($stid);
						$fna=$dat->student_image;					
						
						$ext=$request->file('student_image')->getClientOriginalExtension();	 
						$filename = "st_".date('Ymdhis').".".$ext;
						$fname ="mediguru/student_images/".$filename;
						Storage::disk('spaces')->putFileAs("mediguru/student_images",$request->file('student_image'), $filename, 'public');
				
						Storage::disk('spaces')->delete($fna);  //delete file from the disk
					}
				
				$result="";
				
				DB::beginTransaction();
				try{

					$sdat=[
						'name'=>$request->name,
						'gender'=>$request->gender,
						'date_of_birth'=>date_create($request->birth_date)->format('Y-m-d'),
						'mobile'=>$request->mobile,
						'email'=>$request->email,
						'state'=>$request->state,
						'student_image'=>$fname,
					];

					$result=Student::where('id',$stid)->update($sdat);
					
					$sudat=[
						'student_id'=>$stid,
						'mobile'=>$request->mobile,
						'email'=>$request->email,
						'password'=>Hash::make($request->password),
						'status'=>1
					];
					
					$result=User::where('student_id',$stid)->update($sudat);
									
					DB::commit();
					
					if ($result) 
						{
						$response = ['status'=>TRUE,'message'=>"Profile successfully updated."];
					}
					else {
						$response = ['status'=>FALSE, "message" => "Something wrong11, Please try again."];
					}
					
				}
				catch(\Exception $e)
				{
					DB::rollback();
					$response = ['status'=>TRUE,'message'=>$e->getMessage()];
				}
			}
			else
			{
			   $response = ['status'=>FALSE,'message'=>"Mobile already exist."];	
			}
		}

	return response($response, 200);
}




/**
	 * Function check_device
	 * Function to check the application installed device
     * Method : post
     * params : student_id,android_ios_id
	 * return [ true/false]
	 */

public function check_device(Request $request)   //to open app check this device is correct.
{

	$validator = Validator::make($request->all(), [
        'student_id' => 'required',  
		'android_ios_id' => 'required',  
    ]);
	
    if ($validator->fails())
    {
        $response = ['status'=>False, "message" =>'Student id missing.'];
    }
	else
	{
		$stid=$request->student_id;
		$an_ios_id=$request->android_ios_id;
		
		$rs=StudentDevice::where('student_id',$stid)->get()->first();
		if(!empty($rs))
		{
			if(trim($an_ios_id)==trim($rs->androidid))
			{
				$response = ['status'=>True, "message" =>'Device verified.'];
			}
			else
			{
				$response = ['status'=>False, "message" =>'Invalid device.'];
			}
		}
		else
		{
			$response = ['status'=>False, "message" =>'User not found.'];
		}
	}

	return response($response, 200);
}


/**
	 * Function change_password
	 * Function to change the user password
     * Method : post
     * params :old_password, mobile,password
	 * return [ true/false]
	 */

 public function change_password(Request $request) 
	{
		$oldpass=$request->old_password;  //mobile
		$mob=$request->mobile;  //mobile
		$pass=$request->password;
	
		$udt=User::where('mobile',$mob)->get()->first();
		if(Hash::check($request->old_password, $udt->password))
		{
			$ps=['password'=>Hash::make($pass) ];
			$res=User::where('mobile',$mob)->update($ps);

			if($res) 
			{
				$response = [
					'status'=>TRUE,
					'message'=>"Password changed.!",
				];
			}
			else {
				$response = ['status'=>FALSE, "message" => "Student not Found."];
			}
		}
		else
		{
			$response = ['status'=>FALSE, "message" => "Old Password is invalid."];
				
		}
		return response($response, 200);
    }
	
	
	  /**
	 * Function forgot_password 
	 * Function to reset user password
	 * Method: post
	 * @params:mobile,password
	 * return [ true/false ]
	 */
	
    public function forgot_password(Request $request) 
	{
		$mob=$request->mobile;
		$pass=$request->password;
		
			$res=Student::where('mobile','=',$mob)->get()->first();
			if(!empty($res))
			{			
				$ps=['password'=>Hash::make($pass) ];
				
				$where=['student_id'=>$res->id];
								
				$result=User::where($where)->update($ps);

				if($result) 
				{
					$response = [
						'status'=>TRUE,
						'message'=>"Password changed.!",
					];
				}
				else {
					$response = ['status'=>FALSE, "message" => "User not Found."];
				}
			}
			else
			{
				$response = ['status'=>FALSE, "message" => "User not Found."];
			}
		
		return response($response, 200);
    }


    /**
	 * Function check_user_active 
	 * Function to check the uer is active or not
	 * Method: post
	 * @params:mobile,password
	 * return [ true/false ]
	 */


	public function check_user_active(Request $request) 
	{

		//status = 1-active, 2-disabled;
		
		$validator = Validator::make($request->all(), [
			'mobile' => 'required|string',  
		]);
		
		if ($validator->fails())
		{
			return response(['errors'=>'Invalid mobile.'], 200);
		}

		$where=['mobile'=> $request->mobile];  //username->mobile number
		
        $user = User::where($where)->first();
		
        if ($user)
			{
			if($user->status==0)
			{
				$response = ['status'=>FALSE, "message" =>'Account disabled.'];
			}
			else if($user->status==2)
			{
				$response = ['status'=>FALSE, "message" =>'Account temporarily disabled.'];
			}
			else
			{
				$response = ['status'=>TRUE, "message" =>'Account Active.'];
			}
		} 
		else {
			$response = ['status'=>False, "message" =>'User does not exist'];
		}

	return response($response, 200);
}
	
	
	
}
