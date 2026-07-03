<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Subject;
use App\Models\QuestionPaper;
use App\Models\Package;
use App\Models\McqQuestion;

use Validator;
use Session;
use DataTables;

class QuestionPaperController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
    
	$crs = Course::where('course_type',2)->get(); 
	$sub = (new Subject())->getSubjects();
	
	//$qpapers = (new QuestionPaper())->getQuestionPapers();
	
	return view('admin.mcq_question_paper.question_paper',compact('crs','sub'));
	
  }
      
  public function add_question_paper()
   {
    
	$crs = (new Course())->getCourses(); 
	return view('admin.mcq_question_paper.add_question_paper',compact('crs'));
  }
  
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

		$validate=Validator::make($request->all(),QuestionPaper::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new QuestionPaper())->addQuestionPaper($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('question_papers');
	}
	
	
	
	public function edit($id)
	{
		$qp=(new QuestionPaper())->getQuestionPaperById($id);
		$crs=(new Course())->getCourses();
		$sub=(new Subject())->getSubjectsByCourseId($qp->course_id);
		$pkg=(new Package())->getPackagesByCourseId($qp->course_id);
		return view('admin.mcq_question_paper.edit_question_paper',compact('crs','sub','qp','pkg'));
	}
	
	
	public function update_question_paper(Request $request)
	{

		$validate=Validator::make($request->all(),QuestionPaper::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new QuestionPaper())->updateQuestionPaper($request);

			if($result)
			{
				Session::flash('message', 'success#Question paper successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('question_papers');
	}
  
  
   public function destroy($id)
	{

		$result=(new QuestionPaper())->deleteQuestionPaper($id);
		$res=(new McqQuestion())->deleteQuestionByQpaperId($id);

			if($result)
			{
				Session::flash('message', 'success#Question paper successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('question_papers');
	}
		
    public function view_data(Request $request)
	{
		$qp_type=1; //mock test
		
		if ($request->ajax()) {
            $data = (new QuestionPaper())->getQuestionPapers($request,$qp_type);
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
		
		$result=QuestionPaper::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('question_papers');
	}
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=QuestionPaper::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question paper successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('question_papers');
	}

}
