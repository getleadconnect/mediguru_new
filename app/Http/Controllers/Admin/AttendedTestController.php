<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\PackagePayment;
use App\Models\Course;
use App\Models\AttendedTest;
use App\Models\McqTestResult;
use App\Models\Student;

use Validator;
use Session;
use DataTables;

class AttendedTestController extends Controller
{
      
  public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs=(new Course())->getCourses();
	$studs=Student::select('students.*')
	//->leftJoin('courses','mcq_question_papers.course_id','=','courses.id')
	->paginate(10);
	return view('admin.attended_test.student_attended_tests',compact('crs','studs'));
  }
	
  
    public function view_student_names($id)
	{
		
		$data = (new AttendedTest())->getStudentNames($id);
		
		/*if ($request->ajax()) {
            $data = (new AttendedTest())->getStudentNames($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					->rawColumns(['sname'])
                    ->make(true);
        }*/
		return $data;
	}


    public function view_test_details(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new AttendedTest())->getTestDetails($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					//->rawColumns(['sname'])
                    ->make(true);
        }
	}
   
}
