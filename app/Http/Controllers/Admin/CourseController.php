<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\McqTestResult;
use App\Models\User;
use App\Models\Student;
use App\Models\UserHiddenCourse;
use App\Models\Package;
use App\Models\PurchasedPackage;

use App\Models\McqQuestionPaper;

use DB;
use Validator;
use Session;

class CourseController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $crs = (new Course())->getCourses(); 
	return view('admin.course.course_list_view',compact('crs'));
	//return view('admin.course.course_table_view',compact('crs'));
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Course::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Course())->addCourse($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Course successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('courses');
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

		$result=(new Course())->deleteCourse($id);
		Session::flash('message', 'success#'.$result);
		
		if($result)
		{
			Session::flash('message', 'success#Course successfully removed.');
		}
		else
		{
			Session::flash('message', 'danger#Something wrong, try again.');
		}			

			return redirect('courses');
	}
	
	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Course::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Course successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('courses');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Course::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Course successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('courses');
	}
	
	
	public function get_course_features($id)
	{
		$crs=Course::where('id',$id)->first();
		$fres="";
		if(!empty($crs))
		{
			$fres=$crs->features;
		}
		return $fres;
	}		
		
	public function assign_hidden_course()
	{
		 $crs = (new Course())->getHiddenCourses(); 
		 $usr = $this->get_users(); 
		 $hcrs = (new UserHiddenCourse())->getUserAssignedHiddenCourses();
		 $hpkg = $this->get_hidden_course_packages();
		 return view('admin.course.assign_hidden_course',compact('crs','usr','hcrs','hpkg'));
	}
	
	
	public function get_users()
	{
		return User::select('users.*','students.name')
				->leftJoin('students','users.student_id','=','students.id')->orderBy('id','ASC')->get();
	}
	
	
	public function get_hidden_course_packages()
	{
		return Package::select('packages.*','courses.course_name')
		       ->leftJoin('courses','packages.course_unique_id','=','courses.unique_id')
			   ->where('courses.course_type',1)->orderBy('id','ASC')->get();
	}
	
		
	public function course_assign_to_user(Request $request)  //hidden course only
	{
		
		$stid=$request->assign_student_id;
		$cuid=$request->assign_course_unique_id;
		$pkgid=$request->assign_package_id;
		
		$res=UserHiddenCourse::where('student_id',$stid)->where('course_unique_id',$cuid)->count();
		
		if($res>0)
		{
			Session::flash('message', 'danger#Course already assigned.');
		}
		else
		{
			
			$result="";
		
			DB::beginTransaction();
			try{

				$result=UserHiddenCourse::create([
				'student_id'=>$stid,
				'course_unique_id'=>$cuid,
				]);
							
				$result=PurchasedPackage::create([
					'student_id'=>$stid,
					'course_unique_id'=>$cuid,
					'package_id'=>$pkgid,
					'promocode'=>null,
					'promocode_amount'=>null,
					'referral_code'=>null,
					'referral_amount'=>null,
					'amount'=>0,
					'net_amount'=>0,
					'status'=>1
				]);
			
			DB::commit();
			}
			catch(\Exception $e)
			{
				//\Log::info($e);
				 DB::rollback();
			}		
			
			if($result)
				{
					Session::flash('message', 'success#Course successfully assigned.');
				}
				else
				{
					Session::flash('message', 'danger#Something wrong, try again.');
				}		
		}			

	return redirect('assign_hidden_course');
		
	}
	
	public function delete_user_hidden_course($id)
	{
		
		$res=UserHiddenCourse::find($id);
		
		if(!empty($res))
		{
		$res1=PurchasedPackage::where('student_id',$res->student_id)
			->where('course_unique_id',$res->course_unique_id)->delete();	
			
		$result=$res->delete();
		}
		
		if($result)
			{
				Session::flash('message', 'success#Course successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}	
			
		return redirect('assign_hidden_course');
				
	}
	
	// course schedule -------------------------------------------------------------------------
	
	public function course_schedule(Request $request)
	{
		
		 $crs = (new Course())->getCourses(); 
		 $csh = (new CourseSchedule())->getCourseSchedules();
		 return view('admin.course.course_schedule',compact('crs','csh'));
		
	}
	
	public function save_course_schedule(Request $request)
	{
		
		   $result=(new CourseSchedule())->addSchedule($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Course schedule successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('course_schedule');
		
	}
	
	public function edit_course_schedule($id)
	{
		
		 $crs = (new Course())->getCourses(); 
		 $csh = (new CourseSchedule())->getCourseScheduleById($id);
		 return view('admin.course.edit_course_schedule',compact('crs','csh'));
		
	}
	
	public function update_course_schedule(Request $request)
	{
		
		   $result=(new CourseSchedule())->updateSchedule($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Course schedule successfully  updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('course_schedule');
		
	}
	
	public function view_course_schedule_by_id($id)
	{
		$dat=(new CourseSchedule())->getCourseScheduleById($id);
		if(!empty($dat))
		{
			$dt=$dat->course_schedule;
		}
		else
		{
			$dt="No Data found.";
		}
		
		echo $dt;
	}
	
	
	public function get_course_subscription_end_date($id)
	{
		$res=Course::whereId($id)->first();
		$sed='';
		if(!empty($res))
		{
			$sed=$res->subscription_end_date;
		}
		echo $sed;
	}


	public function delete_course_schedule($id)
	{
		
		$res=CourseSchedule::find($id);
		
		if(!empty($res))
		{
			$result=$res->delete();
		}
		
		if($result)
			{
				Session::flash('message', 'success#Course schedule successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}	
			
		return redirect('course_schedule');
				
	}


// COURSE RE-ORDERING -------------------------------------------------------//

public function get_course_for_reorder() 
{
	
	$dats=Course::orderBy('reorder_no','ASC')->get();
		
	$opt='';
	if(!$dats->isEmpty())
	{
		foreach($dats as $key=>$r)
		{
		$opt.='<li class="ui-state-default" data-id="'.$r->id.'">'.++$key." - ".strtoupper($r->course_name).'</li>';
		}
	}
	return $opt;
}

	
	public function set_course_reorder(Request $request)
	{
		$cids=$request->crsids;
		$crs_ids=explode(',',$cids);
		
		$result='';
		
		if(count($crs_ids)>0)
		{
			foreach($crs_ids as $key=>$r)
			{
				$new=['reorder_no'=>++$key];
				$result=Course::where('id',$r)->update($new);
			}
		}
		
		Session::flash('message', 'success#Course re-order successfully completed.');
		
		return $result;
	}

	
	/*public function get_rank($qid)
	{
		$qpid=$qid;
		$rank_list=McqTestResult::select('student_id','score')->where('question_paper_id',$qpid)->get()->toArray();
			
			//$rank_list=array();
			$last_v=0;$i=0;
			usort($rank_list,array($this,'sortByMark'));
			
				foreach ($rank_list as $m => $v) 
				{
						if ($v['score'] != $last_v)
						{
						   $i++;
						   $last_v = $v['score'];
						}
					  $rank_list[$m]['student_id'] = $v['student_id'];
					  $rank_list[$m]['rank'] = $i;
				}
			
			$key = array_search('52', array_column($rank_list, 'student_id'));
			//------------------------------
			if($key=="" or $key==null){$key=0;$my_rank=0;}
			
			if(!empty($rank_list))
			{
			   $my_rank=$rank_list[$key]['rank'];
			}

	}		
	
	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}
	*/
	
	
}
