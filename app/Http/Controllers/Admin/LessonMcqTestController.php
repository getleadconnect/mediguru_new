<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\VideoImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Material;
use App\Models\LessonMcqTest;
use App\Models\Course;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class LessonMcqTestController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs= (new Course())->getCourses(); 
	$sub= (new Subject())->getSubjects();  
	return view('admin.lesson_items.lesson_mock_test',compact('crs','sub'));
  }
 	
  public function store(Request $request)
   {
		   $result=(new LessonMcqTest())->addLessonMcqTest($request);
		   
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
	
	public function view_lesson_mcq_qpapers()
	{
		$sub= (new Subject())->getSubjects();  
		return view('admin.lesson_items.view_lesson_mock_tests',compact('sub'));
	}
	
	public function view_lesson_qpapers(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonMcqTest())->viewLessonMcqQpapers($request);
            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','icon'])
                    ->make(true);
        }
	}
	
	
   public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonMcqTest())->viewMcqQpapers($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					->addColumn('selbtn',function($data)
					{
						//return '<input type="checkbox" class="sub_chk" data-id="'.$data['id'].'" style="width:20px;height:20px;" ></label>';
						return  '<button type="button" class="mselect btn btn-primary btn-sm" title="Add Question paper" style="padding: 5px 5px 5px 10px;"><i class="fa fa-plus"></i></button>';
					})
                    ->rawColumns(['selbtn'])
                    ->make(true);
        }
	}
	
	
	public function get_lesson_mcq_tests(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonMcqTest())->LessonMcqTests($request);
            return DataTables::of($data)
				->addIndexColumn()
				
				->rawColumns(['icon','action','dat','ord'])
				->make(true);
        }
	}
   
    public function add_mcq_qpaper_order_no(Request $request)  //question paper
	{
		$new=['order_no'=>$request->order_no];
		$result=LessonMcqTest::where('id',$request->mitem_id)->update($new);

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

		$result=(new LessonMcqTest())->deleteLessonMcqTest($id);

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
