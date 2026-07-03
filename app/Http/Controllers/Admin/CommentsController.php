<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Models\Course;
use App\Models\Subject;   //it is sub-courses
use App\Models\MaterialComment;

use Validator;
use Session;
use DataTables;

class CommentsController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
    
	$crs = (new Course())->getCourses(); 
	//$sub = (new Subject())->getSubjects(); 
	return view('admin.feedbacks.view_feedbacks',compact('crs'));
  }
    
  
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new MaterialComment())->viewMaterialComments($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['mtype','action'])
                    ->make(true);
        }
	}
   
  
   public function destroy($id)
	{

		$result=(new MaterialComment())->deleteComment($id);

			if($result)
			{
				Session::flash('message', 'success#Comment successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('comments');
	}
	
	
	
}
