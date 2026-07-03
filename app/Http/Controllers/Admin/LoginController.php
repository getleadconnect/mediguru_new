<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

use Validator;
use Session;
use Auth;
use App\Models\Admin;
use App\Models\RemovedStudent;
use App\Models\User;
use App\Models\Student;
use App\Models\PurchasedPackage;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
  protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
		 
   public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    } 
	 
   public function show_Login_Form()
	{
		
		if(auth()->guard('admin')->user())
		{
			//$stid=Auth::guard('admin')->user()->student_id;
			return redirect('dashboard');
		}
		else
		{
			return view('admin.login.login');
		}
	}


   public function login(Request $request)
	{
		//Session::reflash();
		$validate=Validator::make($request->all(),[
	        'email'    => 'required',
	        'password' => 'required',
	       ]);        
    
		if($validate->fails())
		{
			return back()->withErrors(['err'=>"Email/Password is invalid."])->withInput();
		}
		
		$email=trim($request->email);
		
		if (Auth::guard('admin')->attempt($request->only('email','password')))
		{
				$ad=Admin::where('email',$email)->get()->first();
				
				Session::put(['admin_id'=>$ad->id]);
				Session::put(['admin_name'=>$ad->name]);
				Session::put(['admin_role_id'=>$ad->role_id]);
				return redirect('dashboard');
				
		 }
		
		return back()->withErrors(['err' => 'Invalid Email/Password.']);
	}
	
   protected function guard()
	{
		return auth()->guard('admin');
	} 
	
   public function logout(Request $request)
	{
		Session::flush();
		Auth::logout();
		return redirect('login');
	}	

// Delete user account

	public function delete_account()
	{
		return view('admin.user.delete_user_account');
	}


public function delete_user_account(Request $request)
{

	$name=$request->reg_name;
	$mobile=$request->reg_mobile;
	$reason=$request->reg_reason;
	$pass=$request->reg_password;
		
	$usrdt=User::where('mobile',$mobile)->first();
	
		$res=0;
		if(!empty($usrdt))
		{
			if(Hash::check($request->reg_password, $usrdt->password))
			{
				$stid=$usrdt->student_id;
				$res1 = Student::where('id',$stid)->first();	
				$result = $usrdt->delete();	

				$st_result=RemovedStudent::create([
						'student_id'=>$res1->id,
						'name'=> $res1->name,
						'gender'=>$res1->gender,
						'date_of_birth'=>$res1->date_of_birth,
						'mobile'=>$res1->mobile,
						'email'=>$res1->email,
						'state'=>$res1->state,
						'student_image'=>$res1->student_image,
						'package_status'=>$res1->package_status,
						'status'=>$res1->status,
					 ]);
				
				$p_result=PurchasedPackage::where('student_id',$stid)->delete();
				
				$res1->delete();

				$res=1;	
			}
			else
			{
				$res=0;
			}
		}		
		else { 
		$res=0;	
		}		
	return $res;
	
}


}
