<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Subject;
use App\Models\McqQuestionPaper;
use App\Models\McqQuestion;

use Validator;
use Session;
use DataTables;

class McqQuestionPaperController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

	$crs = (new Course())->getCourses();
	return view('admin.mcq_question_paper.mcq_question_paper',compact('crs'));
	
  }
      
  /*public function add_question_paper()
   {
    
	$crs = (new Course())->getCourses(); 
	return view('admin.mcq_question_paper.add_question_paper',compact('crs'));
  }*/
  
  
  public function get_subjects_by_course_id($id)
  {
	$subjs = (new Subject())->getSubjectsByCourseId($id);
	$opt="<option value=''>--select--</option>";
	foreach($subjs as $s)
	{
	 $opt.="<option value='".$s->id."'>".$s->subject_name."</option>";	
	}
	echo $opt;
  }
   
 
  public function store(Request $request)
	{
		$qptype=1;
	
		$validate=Validator::make($request->all(),McqQuestionPaper::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new McqQuestionPaper())->addQuestionPaper($request,$qptype);
		   
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing111, try again.');
			}				

			return redirect('mcq_question_papers');
	}
	
	
	
	public function edit($id)
	{
		$crs=(new Course())->getCourses();
		$qp=(new McqQuestionPaper())->getQuestionPaperById($id);
		return view('admin.mcq_question_paper.edit_question_paper',compact('crs','qp'));
	}
	
	
	public function update_question_paper(Request $request)
	{

		$validate=Validator::make($request->all(),McqQuestionPaper::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new McqQuestionPaper())->updateQuestionPaper($request);

			if($result)
			{
				Session::flash('message', 'success#Question paper successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('mcq_question_papers');
	}
  
  
   public function destroy($id)
	{

		$result=(new McqQuestionPaper())->deleteQuestionPaper($id);
		$res=(new McqQuestion())->deleteQuestionByQpaperId($id);

			if($result)
			{
				Session::flash('message', 'success#Question paper successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('mcq_question_papers');
	}
		
    public function view_data(Request $request)
	{
		$qptype=1;
		
		if ($request->ajax()) {
            $data = (new McqQuestionPaper())->viewQuestionPapers($request,$qptype);
            return DataTables::of($data)
                    ->addIndexColumn()
					
							/*->editColumn('qpname',function($data){
								return $data['status']? '<span><b>Active</b></span>': '<span><b>Active</b></span>';
							})
							->addColumn('action', function($row){
								//$btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"> View</a>';
							})*/
					
                    ->rawColumns(['action','qpname','ttime','status','qpicon','course'])
                    ->make(true);
        }
	}
	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=McqQuestionPaper::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('mcq_question_papers');
	}
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=McqQuestionPaper::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('mcq_question_papers');
	}

}
