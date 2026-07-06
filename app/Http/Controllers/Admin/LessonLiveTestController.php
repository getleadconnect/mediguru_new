<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\LessonLiveTest;
use App\Models\Course;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class LessonLiveTestController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs= (new Course())->getCourses();  
	$sub= (new Subject())->getSubjects();  
	return view('admin.lesson_items.lesson_live_test',compact('crs','sub'));
  }
 	
	public function view_lesson_live_qpapers()
	{
		$sub= (new Subject())->getSubjects();  
		return view('admin.lesson_items.view_lesson_live_tests',compact('sub'));
	}


	public function view_lesson_qpapers(Request $request)
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
		   $result=(new LessonLiveTest())->addLessonLiveTest($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Video successfully added.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				$res=0;
			}				

			//return redirect('class_videos');
			return $res;
	}
	
   public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonLiveTest())->viewLiveQpapers($request);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('selbtn',function($data)
				 {
					//return '<input type="checkbox" class="sub_chk" data-id="'.$data['id'].'" style="width:20px;height:20px;" ></label>';
					return  '<button type="button" class="mselect btn btn-primary btn-sm" title="Add Question paper" style="padding: 3px 3px 3px 8px;"><i class="fa fa-plus"></i></button>';
				})
                ->rawColumns(['selbtn'])
                ->make(true);
        }
	}
		
	public function get_lesson_live_tests(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonLiveTest())->LessonLiveTests($request);
            return DataTables::of($data)
				->addIndexColumn()
				
				->rawColumns(['icon','action','dat','ord'])
				->make(true);
        }
	}
   
   public function add_live_test_order_no(Request $request)  //question paper
	{
		$new=['order_no'=>$request->order_no];
		$result=LessonLiveTest::where('id',$request->ltitem_id)->update($new);

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
  
  
  
   public function destroy($id)
	{

		$result=(new LessonLiveTest())->deleteLessonLiveTest($id);

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
