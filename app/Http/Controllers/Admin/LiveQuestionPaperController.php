<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Subject;
use App\Models\LiveQuestionPaper;
use App\Models\Package;
use App\Models\McqQuestion;

use Validator;
use Session;
use DataTables;

class LiveQuestionPaperController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs = (new Course())->getCourses();
	return view('admin.live_question_paper.live_question_paper',compact('crs'));
	
  }
 
   public function save_live_qpaper(Request $request)
	{

		$validate=Validator::make($request->all(),LiveQuestionPaper::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new LiveQuestionPaper())->addQuestionPaper($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('live_question_papers');
	}
	
 
  public function get_lmt_subjects_by_course_id($id)
  {
	$subjs = (new Subject())->getSubjectsByCourseId($id);
	$opt="<option value=''>--select--</option>";
	foreach($subjs as $s)
	{
	 $opt.="<option value='".$s->id."'>".$s->subject_name."</option>";	
	}
	echo $opt;
  }

	public function edit($id)
	{
		$crs = (new Course())->getCourses();
		$qp=(new LiveQuestionPaper())->getQuestionPaperById($id);
		return view('admin.live_question_paper.edit_live_question_paper',compact('qp','crs'));
	}
	
	
	public function update_live_question_paper(Request $request)
	{

		$validate=Validator::make($request->all(),LiveQuestionPaper::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new LiveQuestionPaper())->updateQuestionPaper($request);

			if($result)
			{
				Session::flash('message', 'success#Question paper successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('live_question_papers');
	}
  
  
   public function destroy($id)
	{

		$result=(new LiveQuestionPaper())->deleteQuestionPaper($id);
		$res=(new McqQuestion())->deleteQuestionByQpaperId($id);

			if($result)
			{
				Session::flash('message', 'success#Question paper successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			//return redirect('question_papers');
			return $result;
	}
	
  
   public function delete_live_qpaper($id)
	{

		$result=(new LiveQuestionPaper())->deleteQuestionPaper($id);
		$res=(new McqQuestion())->deleteQuestionByQpaperId($id);

			if($result)
			{
				Session::flash('message', 'success#Question paper successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('live_question_papers');
	}

	
    public function view_live_data(Request $request)
	{
		$qp_type=2; //live mock test
		
		if ($request->ajax()) {
            $data = (new LiveQuestionPaper())->viewQuestionPapers($request,$qp_type);
            return DataTables::of($data)
                    ->addIndexColumn()
					
							/*->editColumn('qpname',function($data){
								return $data['status']? '<span><b>Active</b></span>': '<span><b>Active</b></span>';
							})
							->addColumn('action', function($row){
								//$btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"> View</a>';
							})*/
					
                    ->rawColumns(['action','qpname','ttime','tdate','status','qpicon','marks'])
                    ->make(true);
        }
	}
		
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=LiveQuestionPaper::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('live_question_papers');
	}
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=LiveQuestionPaper::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('live_question_papers');
	}

}
