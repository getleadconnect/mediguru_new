<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\McqImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Course;
use App\Models\QuestionPaper;
use App\Models\McqQuestion;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class McqQuestionController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs = (new Course())->getCourses();
	return view('admin.mcq_question.mcq_questions',compact('crs'));
  }
      
  public function add_question(Request $request)
   {
	   $sub=(new Subject())->getSubjects();
	   return view('admin.question.add_question',compact('sub'));
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Question::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Question())->addQuestion($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Question successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('add_question');
	}
	
  
   public function destroy($id)
	{

		$result=(new McqQuestion())->deleteQuestion($id);

			if($result)
			{
				Session::flash('message', 'success#Question successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('mcq_questions');
	}
	
    public function view_data(Request $request)
	{
		$qpid=$request->searchByQpaper;
		if($qpid!="")
		{
			Session::put(['mcq_qpaper_id'=>$qpid]);  //question bank subject id
		}
		else
		{
			$qpid=Session::get('mcq_qpaper_id');
		}
		
		if ($request->ajax()) {
            $data = (new McqQuestion())->getMcqQuestions($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['action','quest','answer','qmode','expl'])
                    ->make(true);
        }
	}


	public function add_pq_subject(Request $request)
	{
		
		$result=(new Subject())->addSubject($request);
		
		if($result)
			{
				Session::flash('message', 'success#Subject successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				
			
			return redirect('prepare_questions');
	}
	

	
	public function get_question_paper_by_subject_id($id)
	{
		$dat=(new QuestionPaper())->getQuestionPaperBySubjectId($id);
		$opt="<option value=''>--select--</option>";
			foreach($dat as $r)
			{
				$opt.="<option value='".$r->id."'>".$r->question_paper_name."</option>";
			}
		echo $opt;
	}
	
	
	public function save_qpaper_questions(Request $request)
	{
	     $result=(new McqQuestion())->addMcqQuestion($request);
		 if($result)
			{
				Session::flash('message', 'success#Questions successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				
			
			return redirect('prepare_questions');
	}		
	
	
	
	
	
}