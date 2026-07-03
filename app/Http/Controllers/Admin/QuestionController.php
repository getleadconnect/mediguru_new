<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\QuestImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Course;
use App\Models\QbSubject;
use App\Models\QuestionPaper;
use App\Models\Question;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class QuestionController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

	$sub = (new QbSubject())->getQbSubjects();
	return view('admin.question.questions',compact('sub'));
	
  }
      
  public function add_question(Request $request)
   {
	   $sub=(new QbSubject())->getQbSubjects();
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
	
	
	public function edit($id)
	{
		$qt=(new Question())->getQuestionById($id);
		$sub=(new QbSubject())->getQbSubjects();
		return view('admin.question.edit_question',compact('sub','qt'));
	}
	
	
	public function update_question(Request $request)
	{

		$validate=Validator::make($request->all(),Question::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Question())->updateQuestion($request);

			if($result)
			{
				Session::flash('message', 'success#Question successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('questions');
	}
  
  
   public function destroy($id)
	{

		$result=(new Question())->deleteQuestion($id);

			if($result)
			{
				Session::flash('message', 'success#Question successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('questions');
	}
	
    public function view_data(Request $request)
	{
	
		$subid=$request->searchBySubject;
		if($subid!="")
		{
			Session::put(['qb_sub_id'=>$subid]);  //question bank subject id
		}
		else
		{
			$subid=Session::get('qb_sub_id');
		}
		
		
		if ($request->ajax()) {
            $data = (new Question())->getQuestions($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
							/*->editColumn('qpname',function($data){
								return $data['status']? '<span><b>Active</b></span>': '<span><b>Active</b></span>';
							})
							->addColumn('action', function($row){
								//$btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm"> View</a>';
							})*/
			        /*->filter(function ($instance) use ($request) {
                        if ($request->$request->searchByQpaperid!="") {
                            $instance->where('question_paper_id', $request->searchByQpaperid);
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                            });
                        }
                    })*/
					
                    ->rawColumns(['action','course','quest','answer','status'])
                    ->make(true);
        }
	}

	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Question::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('questions');
	}
	
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Question::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Question successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('questions');
	}
	
	public function import_questions()
	{
	
	$sub = (new QbSubject())->getQbSubjects(); 
	return view('admin.question.import_question',compact('sub'));	

	}
	
	public function import_to_excel(Request $request) 
    {
		$subid=$request['subject_id'];
			
		try{
			$success=Excel::import(new QuestImport($subid),request()->file('file'));
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
		
	
	
}