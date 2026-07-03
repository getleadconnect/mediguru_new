<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Subject;
use App\Models\Lesson;

use Validator;
use Session;


class CommonFunctionController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	
  }

	public function save_subject(Request $request)
	{
		
		$result=(new Subject())->addSubject($request);
		
		if($result)
			{
				Session::flash('message', 'success#Subject successfully added.');
				$res=$result->id;
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
				$res=0;
			}				
			
			//return redirect('prepare_questions');
			return $res;
	}
	
		
	
	public function save_lesson(Request $request)
	{
		
		$result=(new Lesson())->addLesson($request);
		
		if($result)
			{
				Session::flash('message', 'success#Lesson successfully added.');
				$res=$result->id;
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
				$res=0;
			}				
			
			//return redirect('prepare_questions');
			return $res;
	}
	

	
}
