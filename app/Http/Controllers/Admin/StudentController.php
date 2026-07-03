<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use App\Models\Package;
use App\Models\Staff;
use App\Models\Promocode;
use App\Models\SalaryPayment;

use Validator;
use Session;
use DataTables;

class StudentController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
     $crs=(new Course())->getCourses();
	 $rfc=(new Staff())->getReferralCodes();
	 return view('admin.student.students',compact('crs','rfc'));
  }
  
   public function add_student()
  {
	$crs=(new Course())->getCourses();
	$rfc=(new Staff())->getReferralCodes();
	
	return view('admin.student.add_student',compact('crs','rfc'));
	
  }   
   
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Student::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		$res=Student::where('mobile',$request->mobile)->count();
		if($res>0)
		{
			Session::flash('message', 'danger#Mobile number already exist, Try again.');
			return redirect('add_student');
		}
		else
		{
			
			$res1=User::where('mobile',$request->mobile)->count();
			if($res1>0)
			{
				Session::flash('message', 'danger#Mobile number already exist, Try again.');
				return redirect('add_student');
			}
			else
			{
				$result=(new Student())->addStudent($request); //add student and user details
		
				if($result)
				{
					Session::flash('message', 'success#Student details successfully added.');
				}
				else
				{
					Session::flash('message', 'danger#Details missing, try again.');
				}				
			}
			return redirect('add_student');
	    }
 }

  public function check_mobile($mob)
	{
		$res=Student::where("mobile",$mob)->count();
		if($res>0)
			echo 1;
		else
			echo 0;
	}
	
	
  public function edit($id)
	{
		$sts=(new Student())->getStudentById($id);
		return view('admin.student.edit_student',compact('sts'));
	}
	

  public function update_student(Request $request)
	{

		/*$validate=Validator::make($request->all(),Student::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}*/
		
		$result=(new Student())->updateStudent($request);

			if($result)
			{
				Session::flash('message', 'success#Student successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('students');
  }
  
   
   public function destroy($id)
	{

		$result=(new Student())->deleteStudent($id);

			if($result)
			{
				Session::flash('message', 'success#Student successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('students');
	}
	
    public function view_data(Request $request)
	{
		
		//$qpid=$request->searchByQpaper;
		
		if ($request->ajax()) {
            $data = (new Student())->getStudents($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','pkg','name','gender','simage','status'])
                    ->make(true);
        }
	}
	
	
	//---------------------------------------------------------
		
  public function add_package($stid)
	{
		$crs=(new Course())->getCourses();
		$rfc=(new Staff())->getReferralCodes();
		return view('admin.student.add_package',compact('stid','crs','rfc'));
	}
	
  public function update_package(Request $request)
	{
		
		$result=(new Student())->addPackage($request);

			if($result)
			{
				Session::flash('message', 'success#Package successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

		return redirect('students');
	}
		
	//--------------------------------------------------------------------------	
	
  public function get_students_by_course_unique_id($uid)
	{
		$sts = (new Student())->getStudentsByCourseUniqueId($uid);
		$opt="<option value=''>--select--</option>";
		foreach($sts as $r)
		{
		 $opt.="<option value='".$r->id."'>".$r->name."</option>";	
		}
		echo $opt;
	}
	
  public function get_package_amount($id,$period)
	{
		$res=(new Package())->getPackageById($id);
		if($period==1){
			$amt=$res->rate;
		}
		else if($period==3){
			$amt=$res->rate_3_months;
		}
		else
		{
			$amt=$res->rate_6_months;
		}
		
		return response()->json(['amount'=>$amt,'package_type'=>$res->package_type]);		
	}
	
	
  public function get_promocodes_by_course_id($id)
  {
	$crsid=Course::where('unique_id',$id)->pluck('id');  
	$pcds = (new Promocode())->getPromocodeByCourseId($crsid);
	$opt="<option value=''>--select--</option>";
	foreach($pcds as $r)
	{
	 $opt.="<option value='".$r->promocode."'>".$r->promocode."</option>";	
	}
	echo $opt;
  }
  
  
  public function get_promocode_amount($code,$pkid)
	{
		$res=(new Promocode())->getPromocodeAmount($code);
		
		$pkg=Package::where('id',$pkid)->first();
		$amt=0;
		if(!empty($pkg))
		{
			$pamt=floor(($pkg->rate*$res->percentage)/100);
			$amt=$pamt;
		}
		echo $amt;
	}
	
	
	public function get_referral_code_amount($code)
	{
		$res=(new Staff())->getReferralCodeAmount($code);
		$amt=$res->referral_value;
		echo $amt;
	}
 /* 
  public function get_question_paper_by_subject_id($id)
  {
	$qps = (new QuestionPaper())->getQuestionPaperBySubjectId($id);
	$opt="<option value=''>--select--</option>";
	foreach($qps as $r)
	{
	 $opt.="<option value='".$r->id."'>".$r->question_paper_name."</option>";	
	}
	echo $opt;
  }
    */
	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Student::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Student successfully activated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('questions');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Student::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('students');
	}
	
//============================IMPORT BULK STUDENT DETAILS========================================


  public function import_students()
	{
	  return view('admin.student.import_students');	
	}
	
	public function import_student_users(Request $request) 
    {
			
		try{
			$success=Excel::import(new StudentImport(),request()->file('file'));
			if($success)
			{
				Session::flash('message', 'success#Student details successfully imported.');
			}
		}
		catch(Exception $e)
		{
			Session::flash('message', 'danger#'.$e->getMessage());
		}
		return back();
    }

	
}