<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\VideoImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Course;
use App\Models\Subject;   //it is sub-courses
use App\Models\Chapter;
use App\Models\ClassVideo;
use App\Models\VimeoVideo;

use Validator;
use Session;
use DataTables;

class ImportVideosController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs = (new Course())->getCourses(); 
	return view('admin.class_videos.import_vimeo_videos',compact('crs'));	
  }
  
  public function import_from_excel(Request $request) 
    {
		$crsid=$request['course_id'];
			
		try{
			$success=Excel::import(new VideoImport($crsid),request()->file('file'));
			if($success)
			{
				Session::flash('message', 'success#Videos successfully imported.');
			}
		}
		catch(Exception $e)
		{
			Session::flash('message', 'danger#'.$e->getMessage());
		}
		return back();
    }
	
 	public function edit($id)
	{
		$vd=(new VimeoVideo())->getVideoById($id);
		$crs=(new Course())->getCourses();
		return view('admin.class_videos.edit_vimeo_video',compact('crs','vd'));
	}
	
	
	public function update_video(Request $request)
	{

		$result=(new VimeoVideo())->updateVideo($request);

			if($result)
			{
				Session::flash('message', 'success#Video successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('import_videos');
	}
  
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new VimeoVideo())->viewVimeoVideos($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['action',])
                    ->make(true);
        }
	}
   
  
   public function destroy($id)
	{

		$result=(new VimeoVideo())->deleteVideo($id);

			if($result)
			{
				Session::flash('message', 'success#Video successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('import_videos');
	}
	
	
	
	
}
