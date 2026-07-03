<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Subject;   //it is sub-courses
use App\Models\Lesson;

use Validator;
use Session;
use DataTables;

class LessonController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs = (new Course())->getCourses();
	$sub = (new Subject())->getSubjects(); 
	return view('admin.lessons.lessons',compact('crs','sub'));
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Lesson::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

	    
		$result=(new Lesson())->addLesson($request);
	   
		if($result)
		{
			Session::flash('message', 'success#Lesson successfully added.');
		}
		else
		{
			Session::flash('message', 'danger#Details missing, try again.');
		}				
		return redirect('lessons');
		
	}
	
	
	public function edit($id)
	{
		$les=(new Lesson())->getLessonById($id);
		$crs=(new Course())->getCourses();
		$sub=(new Subject())->getSubjectsByCourseId($les->course_id);
		return view('admin.lessons.edit_lesson',compact('crs','les','sub'));
	}
	
	
	public function update_lesson(Request $request)
	{

		$validate=Validator::make($request->all(),Lesson::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Lesson())->updateLesson($request);

			if($result)
			{
				Session::flash('message', 'success#Lesson successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('lessons');
	}
  
  
   public function view_data(Request $request)
	{
		
		//$qpid=$request->searchByQpaper;
		
		if ($request->ajax()) {
            $data = (new Lesson())->viewLessons($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['action','cicon','status'])
                    ->make(true);
        }
	}
   
   
  public function get_lessons_by_subject_id($id)
  {
	  $cptr= (new Lesson())->getLessonsBySubjectId($id);
	  $opt="<option value=''>--select--</option>";
	  if(!$cptr->isEmpty())
	  {
		  foreach($cptr as $r)
		  {
			$opt.="<option value='".$r->id."'>".$r->lesson_name."</option>";  
		  }
	  }
	  return $opt;
	  
  }
  
   public function destroy($id)
	{

		$result=(new Lesson())->deleteLesson($id);

			if($result)
			{
				//Session::flash('message', 'success#Lesson successfully removed.');
				$res=1;
			}
			else
			{
				//Session::flash('message', 'danger#Something wrong, try again.');
				$res=0;
			}				

			//return redirect('lessons');
			return $res;
	}
	
	
	
	public function activate_deactivate($id,$op)
	{

		if($op==1)
		{
		   $res=['status'=>1];
		}
		else
		{
			$res=['status'=>0];
		}
		
		$result=Lesson::whereId($id)->update($res);
		
			if($result)
			{
				if($op==1)
				{
					$res=1;
				}
				else
				{
					$res=2;
				}
			}
			else
			{
				$res=3;
			}				

			return $res;
	}
		
	
	
}
