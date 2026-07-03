<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\DashLiveMockTest;
use App\Models\Course;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class DashLiveMockTestController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs= (new Course())->getCourses();  
	$sub= (new Subject())->getSubjects();  
	return view('admin.dash_live_mock_test.dash_live_mock_test_qpapers',compact('crs','sub'));
  }
 	
	public function view_dash_live_qpapers()
	{
		$sub= (new Subject())->getSubjects();  
		return view('admin.lesson_items.view_lesson_live_tests',compact('sub'));
	}

	public function view_dash_mock_test_qpapers(Request $request)
	{

		if ($request->ajax()) {
			$data = (new LessonLiveTest())->viewLessonLiveQpapers($request);
			return DataTables::of($data)
				   ->addIndexColumn()
					
				   ->rawColumns(['action','icon'])
				   ->make(true);
		}
	}
	
	
  public function store(Request $request)
   {
		   $result=(new DashLiveMockTest())->addLiveMockTest($request);  
		   
			if($result)
			{
				Session::flash('message', 'success#Mock test successfully added.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				$res=0;
			}				

			return $res;
	}
	
	
	public function get_live_mock_test_qpapers($id)
	{
		$qprs = (new DashLiveMockTest())->getLiveQpapersByCourseId($id);
		
		$opt="<option value=''>--select--</option>";
		foreach($qprs as $r)
		{
			$opt.="<option value='".$r->unique_id."'>".$r->question_paper_name."</option>";
		}
		
		return $opt;
		
	}	
	
	
	
   public function view_data(Request $request)
	{
		if ($request->ajax()) {
            $data = (new DashLiveMockTest())->viewDashLiveMockTestQpapers($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					->rawColumns(['action','icon','tdate'])
                    ->make(true);
        }
	}
	
	
	public function get_lesson_live_tests(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonLiveTest())->LessonLiveTests($request);
            return DataTables::of($data)
				->addIndexColumn()
				
				->rawColumns(['icon','action','dat'])
				->make(true);
        }
	}
   
  
   public function destroy($id)
	{

		$result=(new DashLiveMockTest())->deleteDashLiveTest($id);

			if($result)
			{
				Session::flash('message', 'success#Test successfully removed.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
				$res=0;
			}				

			//return redirect('video_lessions');
			return $res;
	}
	
	
	
	
}
