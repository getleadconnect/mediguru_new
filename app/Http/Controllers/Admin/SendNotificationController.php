<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Libraries\Send_Push_Notification;  //custom notification library

use App\Models\Course;
use App\Models\Notification;
use App\Models\McqTestResult;
use App\Models\Student;
use App\Models\User;

use Validator;
use Session;
use DataTables;

class SendNotificationController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $crs = (new Course())->getCourses(); 
	return view('admin.notification.notification',compact('crs'));
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Notification::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Notification())->addNotification($request);
		   
		   $not_result=$this->send_notification($request); //send push notification  
		   
			if($result)
			{
				  
				Session::flash('message', 'success#Notification successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('notifications');
	}


public function send_notification($request)   //push notification 
	{
		$subj_id=$request->subject_id;
		$crs_id=$request->course_unique_id;
		$mtype=$request->message_type;
		$title=$request->title;
		$mesg=$request->message;
		
		try
		{
			if($mtype==1)
			{
				$usrs=User::select('users.student_id','users.fcm_token')
					  ->where('users.status',1)->where('fcm_token','!=',"")->orderBy('id','ASC')->get();

				if(!$usrs->isEmpty())
				{
					foreach($usrs as $r)
					{
						$token=$r->fcm_token;
						$title=$title;
						$message=$mesg;
						$pnot=new Send_Push_Notification();   //call library class
						$res=$pnot->sendNotificationToInfluencer($token, $title, $message, $click = null, $page = null);
					}
				}
			}
			elseif($mtype==2)
			{
				
				$where1 = "FIND_IN_SET('".$subj_id."', packages.subject_id)"; 
								
				$usrs=User::select('users.student_id','users.fcm_token')
					  ->leftJoin('purchased_packages','users.student_id','=','purchased_packages.student_id')
					  ->leftJoin('packages','purchased_packages.package_id','=','packages.id')
					  ->whereRaw($where1)
					  ->where('users.status',1)->where('fcm_token','!=',"")
					  ->groupBy('users.student_id','users.fcm_token')
					  ->orderBy('users.student_id','ASC')->get();

				if(!$usrs->isEmpty())
				{
					foreach($usrs as $r)
					{
						$token=$r->fcm_token;
						$title=$title;
						$message=$mesg;
						$pnot=new Send_Push_Notification();   //call library class
						$res=$pnot->sendNotificationToInfluencer($token, $title, $message, $click = null, $page = null);
					}
				}
			}
			elseif($mtype==3)
			{
				$usrs=User::select('users.student_id','users.fcm_token')
					  ->leftJoin('purchased_packages','users.student_id','=','purchased_packages.student_id')
					  ->where('purchased_packages.course_unique_id',$crs_id)
					  ->where('users.status',1)->where('fcm_token','!=',"")
					  ->groupBy('users.student_id','users.fcm_token')
					  ->orderBy('users.student_id','ASC')->get();

				if(!$usrs->isEmpty())
				{
					foreach($usrs as $r)
					{
						$token=$r->fcm_token;
						$title=$title;
						$message=$mesg;
						$pnot=new Send_Push_Notification();   //call library class
						$res=$pnot->sendNotificationToInfluencer($token, $title, $message, $click = null, $page = null);
					}
				}
			}
			
		return true;
		
		}
		catch(\Exception $e)
		{
			dd($e->getMessage());
			return $e->getMessage();
		}
	}
	
	
	public function view_data(Request $request)
	{

		if ($request->ajax()) {
			$data = (new Notification())->viewNotifications($request);
			return DataTables::of($data)
				   ->addIndexColumn()
					
				   ->rawColumns(['action','status','type',])
				   ->make(true);
		}
	}
	
	
	public function edit($id)
	{
		$crs=(new Course())->getCourseById($id);
		return view('admin.course.edit_course',compact('crs'));
	}
	
	
	 public function update_course(Request $request)
	 {

		$validate=Validator::make($request->all(),Course::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Course())->updateCourse($request);

			if($result)
			{
				Session::flash('message', 'success#Course successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('courses');
	}
  
   public function destroy($id)
	{

		$result=(new Notification())->deleteNotification($id);
		Session::flash('message', 'success#'.$result);
		
		if($result)
		{
			$res=1;
		}
		else
		{
			$res=0;
		}			

		return $res;
	}
	
	public function act_deact_notification($id,$op)
	{

		if($op==1)
		{
			$new=['status'=>1];
		}
		else
		{
			$new=['status'=>2];
		}
		
		$result=Notification::whereId($id)->update($new);
		
			$res=0;
			if($result)
			{
				if($op==1)
				{
					$res=1;
				}
				else
				{
					$res=2;
				}
			}

			return $res;
	}
	
	
}