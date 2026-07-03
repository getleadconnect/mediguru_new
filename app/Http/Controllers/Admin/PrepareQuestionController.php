<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\McqQuestImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Course;
use App\Models\QbSubject;
use App\Models\QuestionPaper;
use App\Models\Question;
use App\Models\Subject;
use App\Models\McqQuestion;
use App\Models\McqQuestionPaper;
use App\Models\LessonVideo;
use App\Models\LessonVideoQuestion;

use Validator;
use Session;
use DataTables;

class PrepareQuestionController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

	$crs = (new Course())->getCourses();
	$sub = (new QbSubject())->getQbSubjects();
	$mcqp = (new McqQuestionPaper())->getMcqQPapers();
	return view('admin.mcq_question.prepare_questions',compact('mcqp','sub','crs'));
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
	
	public function view_data(Request $request)
	{
		
		$subid=$request->searchBySubject;
		$search=$request->search;

		if ($request->ajax()) {

		$dts=Question::select('questions.*','qb_subjects.subject_name')
		->leftJoin('qb_subjects','questions.qb_subject_id','=','qb_subjects.id')
		->where(function($where) use($search)
			    {
					$where->where('questions.question', 'like', '%' .$search . '%')
					->orWhere('questions.answer_1', 'like', '%' .$search . '%')
					->orWhere('questions.explanation', 'like', '%' .$search . '%');
			  });
		
		if($subid!="")
		{
			$dts->where('questions.qb_subject_id',$subid);
		}
		
		$data=$dts->orderBy('questions.id','ASC')->get();

            //$data = (new Question())->getQuestions($request);

            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('status', function($row)
                {
					if($row->status==1)
					$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
					else
					$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
					
					return $st;
				})
				->addColumn('quest', function($row)
				{
					if($row->question!="")
						$qst=$row->question;
					else
						$qst='<img src="'.config('constants.file_path')."/".$row->question_image.'" style="width:200px">';
					return $qst;
				})

				->addColumn('subject', function($row)
				{
					return $row->subject_name;
				})
				->addColumn('answer', function($row)
				{
					$ans="A - ".$row->answer_1."<br>B-".$row->answer_2."<br>C-".$row->answer_3."<br>D-".$row->answer_4;
					return $ans;
				})

				->addColumn('cans', function($row)
				{
					return $row->correst_answer;
				})

				->addColumn('expl', function($row)
				{
					return $row->explanation;
				})

				
				->addColumn('selbtn',function($data)
				{
					return  '<button type="button" class="qselect btn btn-primary btn-sm" title="Select Question" style="padding: 5px 5px 5px 10px;"><i class="fa fa-plus"></i></button>';
				})
				->addColumn('action', function($row)
				{
				
				$btn='<a href="#" id="'.$row->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="'.url('delete_question').'/'.$row->id.'" id="conf" class=" btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
				if($row->status==1)
					  $btn.='<a href="'.url('deactivate_question').'/'.$row->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_question').'/'.$row->id.'" class="btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				return $btn;
				})
                ->rawColumns(['delbtn','selbtn','action','course','quest','answer','status'])
                ->make(true);
        }
	}


    /*public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new Question())->getQuestions($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					->addColumn('selbtn',function($data)
					{
						return  '<button type="button" class="qselect btn btn-primary btn-sm" title="Select Question" style="padding: 5px 5px 5px 10px;"><i class="fa fa-plus"></i></button>';
					})
                    ->rawColumns(['delbtn','selbtn','action','course','quest','answer','status'])
                    ->make(true);
        }
	}*/

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
	
	
	public function save_question_paper(Request $request)
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

			return back();
	}

		
	public function get_question_paper_by_course_id($id)
	{
		$dat=(new McqQuestionPaper())->getQuestionPaperByCourseId($id);
		$opt="<option value=''>--select--</option>";
			foreach($dat as $r)
			{
				$opt.="<option value='".$r->id."'>".$r->question_paper_name."</option>";
			}
		echo $opt;
	}
	
	public function get_total_questions($qpid)
	{
		$cnt=(new McqQuestion())->getTotalQuestions($qpid);
		echo $cnt;
	}
	
	
	public function import_questions()
	{
		$crs = (new Course())->getCourses();
		return view('admin.mcq_question.import_question',compact('crs'));
	}
	
	public function import_mcq_to_excel(Request $request)
	{
	
		$crsid=$request['course_id'];
		$subid=$request['subject_id'];
		$qpid=$request['qpaper_id'];
					
		try{
			$success=Excel::import(new McqQuestImport($qpid),request()->file('file'));
			if($success)
			{
				Session::flash('message', 'success#Question successfully imported.');
			}
		}
		catch(Exception $e)
		{
			Session::flash('message', 'danger#'.$e->getMessage());
		}
		return back();
    }
	
//---------------------------VIDEO CLASS QUESTIONS--------------------------------------------------------------------------


public function  prepare_video_questions()
  {

	$crs = (new Course())->getCourses();
	$sub = (new QbSubject())->getQbSubjects();
	$mcqp = (new McqQuestionPaper())->getMcqQPapers();
	return view('admin.mcq_question.prepare_video_questions',compact('mcqp','sub','crs'));
  }	
	
	
public function get_videos_by_subject_id($sid)
{
	$vid=LessonVideo::select('videos.id as video_id','videos.title')->where('subject_id',$sid)
		->leftJoin('videos','lesson_videos.video_unique_id','=','videos.unique_id')->get();
	
	$opt="<option value=''>--select--</option>";
	if(!$vid->isEmpty())
	{
		foreach($vid as $r)
		{
		   $opt.="<option value='".$r->video_id."'>".$r->title."</option>";
		}
	}
	return $opt;
}

public function get_video_total_questions($vid)
	{
		$cnt=LessonVideoQuestion::where('video_id',$vid)->count();
		echo $cnt;
	}


 public function save_video_questions(Request $request)
	{
	     $result=(new LessonVideoQuestion())->addLessonVideoQuestion($request);
		 if($result)
			{
				Session::flash('message', 'success#Questions successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				
			
			return redirect('prepare_video_questions');
	}		
	
public function video_questions(Request $request)
{
	$crs = (new Course())->getCourses();
	return view('admin.mcq_question.view_video_questions',compact('crs'));
}
	
	
public function view_video_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonVideoQuestion())->getVideoQuestions($request);
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action','quest','answer','qmode','expl'])
                ->make(true);
        }
	}

public function destroy($id)
	{

		$result=(new LessonVideoQuestion())->deleteQuestion($id);

			if($result)
			{
				Session::flash('message', 'success#Question successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('video_questions');
	}



}