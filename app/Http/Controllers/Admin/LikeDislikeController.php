<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


use App\Models\Course;
use App\Models\Subject;   //it is sub-courses
use App\Models\MaterialLike;

use Validator;
use Session;
use DataTables;
use DB;

class LikeDislikeController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
    
	$crs = (new Course())->getCourses(); 
	//$sub = (new Subject())->getSubjects(); 
	return view('admin.like_dislike.view_like_dislike',compact('crs'));
  }
    
  
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new MaterialLike())->viewMaterialLikesDislikes($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['uid','lik','dlik','mtype','action'])
                    ->make(true);
        }
	}
   
  
   public function destroy($id)
	{

		$result=(new MaterialLike())->deleteLikeDislike($id);

			if($result)
			{
				Session::flash('message', 'success#Details successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('like_dislikes');
	}
	
	
	
}
