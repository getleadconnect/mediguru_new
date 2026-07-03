<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\VideoImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Video;
use App\Models\Course;
use App\Models\Subject;
use App\Models\LessonVideo;

use Validator;
use Session;
use DataTables;

class LessonVideosController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs= (new Course())->getCourses();  
	$sub= (new Subject())->getSubjects();  
	return view('admin.lesson_items.lesson_videos',compact('crs','sub'));
  }
  
  
  public function view_all_lesson_videos()   //view all lesson videos
  {
	$sub= (new Subject())->getSubjects();  
	return view('admin.lesson_items.view_lesson_videos',compact('sub'));
  }
  
  
  public function view_all_videos(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonVideo())->viewAllLessonVideos($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','vicon','vfile'])
                    ->make(true);
        }
	}

//----------------------------------------------------------

  public function store(Request $request)
   {
		   $result=(new LessonVideo())->addLessonVideo($request);
		   
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
            $data = (new LessonVideo())->getVideos($request);  //vimeo videos
            return DataTables::of($data)
                    ->addIndexColumn()
					->addColumn('selbtn',function($data)
					{
						//return '<input type="checkbox" class="sub_chk" data-id="'.$data['id'].'" style="width:20px;height:20px;" ></label>';
						return  '<button type="button" class="qselect btn btn-primary btn-sm" title="Add Video" style="padding: 5px 5px 5px 10px;"><i class="fa fa-plus"></i></button>';
					})
                    ->rawColumns(['selbtn'])
                    ->make(true);
        }
	}
	
	
	public function get_lesson_videos(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonVideo())->LessonVideos($request);
            return DataTables::of($data)
				->addIndexColumn()
				
				->rawColumns(['icon','action','ord','dat'])
				->make(true);
        }
	}
	
	public function add_order_no(Request $request)
	{
		$new=['order_no'=>$request->order_no];
		$result=LessonVideo::where('id',$request->vitem_id)->update($new);

		if($result)
			{
				Session::flash('message', 'success#Order no changed.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Please try again.');
				$res=0;
			}				
		return $res;
	}
	

   
  
   public function destroy($id)
	{

		$result=(new LessonVideo())->deleteLessonVideo($id);

			if($result)
			{
				Session::flash('message', 'success#Lession successfully removed.');
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
