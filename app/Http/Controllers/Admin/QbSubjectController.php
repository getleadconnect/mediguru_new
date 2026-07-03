<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\QbSubject;

use Validator;
use Session;

class QbSubjectController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
 
	$sub = (new QbSubject())->getQbSubjects(); 
	return view('admin.qb_subject.qb_subject',compact('sub'));
	
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),QbSubject::RULES);
		
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing2222, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new QbSubject())->addQbSubject($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Subject successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing1111, try again.');
			}				

			return redirect('qb_subjects');
	}
	
	
	public function edit($id)
	{
		$sub=(new QbSubject())->getQbSubjectById($id);
		return view('admin.qb_subject.edit_qb_subject',compact('sub'));
	}
	
	
	public function update_qb_subject(Request $request)
	{

		$validate=Validator::make($request->all(),QbSubject::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new QbSubject())->updateQbSubject($request);

			if($result)
			{
				Session::flash('message', 'success#Subject successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('qb_subjects');
	}
  
  
   public function destroy($id)
	{

		$result=(new QbSubject())->deleteQbSubject($id);

			if($result)
			{
				Session::flash('message', 'success#Subject successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('qb_subjects');
	}

	
}
