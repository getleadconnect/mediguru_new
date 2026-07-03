<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\VideoImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Video;

use Validator;
use Session;
use DataTables;

class VideosController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	return view('admin.videos.videos_new');
  }
 	
	public function store(Request $request)
	{
				
		$validate=Validator::make($request->all(),Video::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Video())->add_Video($request);
		   
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

	
	public function edit($id)
	{
		$vl=(new Video())->getVideoById($id);
		//return view('admin.videos.edit_video',compact('vl'));
		return view('admin.videos.edit_video_new',compact('vl'));
	}
	
	
	public function update_video(Request $request)
	{

		$validate=Validator::make($request->all(),Video::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		$result=(new Video())->update_video($request);

			if($result)
			{
				Session::flash('message', 'success#Video details successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('videos');
	}
	
  
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new Video())->viewVideos($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','vicon','title','vid','pre'])
                    ->make(true);
        }
	}
   
  
   public function destroy($id)
	{

		$result=(new Video())->deleteVideo($id);

			if($result)
			{
				Session::flash('message', 'success#Video successfully removed.');
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
