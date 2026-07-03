<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\SubCourse;

use Validator;
use Session;

class SubCourseController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
    
	$crs = (new Course())->getCourses(); 
	$sub = (new Subject())->getSubjects(); 
	return view('admin.subject.subject',compact('crs','sub'));
	
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Subject::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Subject())->addSubject($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Subject successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('subjects');
	}
	
	
	public function edit($id)
	{
		$sub=(new Subject())->getSubjectById($id);
		$crs=(new Course())->getCourses();

		return view('admin.subject.edit_subject',compact('crs','sub'));
	}
	
	
	public function update_subject(Request $request)
	{

		$validate=Validator::make($request->all(),Subject::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Subject())->updateSubject($request);

			if($result)
			{
				Session::flash('message', 'success#Subject successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('subjects');
	}
  
  
   public function destroy($id)
	{

		$result=(new Subject())->deleteSubject($id);

			if($result)
			{
				Session::flash('message', 'success#Subject successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('subjects');
	}
	
	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Subject::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Subject successfully activated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('subjects');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Subject::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Subject successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('subjects');
	}
	
}
