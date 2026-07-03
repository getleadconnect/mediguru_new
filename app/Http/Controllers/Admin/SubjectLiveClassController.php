<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\SubjectLiveClass;
use App\Models\Course;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class SubjectLiveClassController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $crs = (new Course())->getCourses(); 
	return view('admin.latest_news.subject_live_class',compact('crs'));
  }

  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),SubjectLiveClass::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing11, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new SubjectLiveClass())->addSubjectLiveClass($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Live class successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('subject_live_class');
	}
	
	
	public function edit($id)
	{
		$crs=(new Course())->getCourses();
		$slc=(new SubjectLiveClass())->getSubjectLiveClassById($id);
		$subj=(new Subject())->getSubjectsByCourseId($slc->course_id);
		return view('admin.latest_news.edit_subject_live_class',compact('crs','subj','slc'));
	}
	
	
	 public function update_subject_live_class(Request $request)
	 {

		$validate=Validator::make($request->all(),SubjectLiveClass::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new SubjectLiveClass())->updateSubjectLiveClass($request);

			if($result)
			{
				Session::flash('message', 'success#Live class successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing-22, try again.');
			}				

			return redirect('subject_live_class');
	}
  
    public function view_data(Request $request)
	{
		
		//$qpid=$request->searchByQpaper;
		
		if ($request->ajax()) {
            $data = (new SubjectLiveClass())->viewSubjectLiveClass($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['cname','title','dat','action','status'])
                    ->make(true);
        }
	}
  
  public function get_more_latest_news($id)  //modal content
  {
	  $res=SubjectLiveClass::where('id',$id)->first();
	  $dat="";
	  if(!empty($res))
	  {
		  $dat=$res->description;
	  }
	  
	  return $dat;
	  
  }
    
  
  
   public function destroy($id)
	{

		$result=(new SubjectLiveClass())->deleteSubjectLiveClass($id);
		Session::flash('message', 'success#'.$result);
		
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
	
	
	public function activate_deactivate_live_class($op,$id)
	{
		
		if($op==1)
		{
			$res=['status'=>1];
		}
		else
		{
			$res=['status'=>2];
		}

		$result=SubjectLiveClass::whereId($id)->update($res);
		
			if($result)
			{
				if($op==1)
				{
					$res="News successfully activated.";
				}
				else
				{
					$res="News successfully deactivated.";
				}
			}
			else
			{
				$res="Deatils missing, try agin.";
			}				

			return $res;
	}
	
	
	
}
