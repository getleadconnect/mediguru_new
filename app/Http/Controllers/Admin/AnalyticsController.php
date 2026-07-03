<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Student;
use App\Models\McqQuestionPaper;
use App\Models\McqTestResult;
use App\Models\McqTestAllResult;
use App\Models\McqQuestion;
use App\Models\Course;

use Session;
use Validator;
use DataTables;

class AnalyticsController extends Controller
{
   
  protected $guard = 'admin';
    
  public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
	{
	//Session::put(['answer_count'=>"",'wrong_count'=>"",'skip_count'=>""]);
	
	$crs=Course::orderBy('id','ASC')->get();
	return view('admin.analytics.question_attendees',compact('crs'));
}
	
  //-------------------------------------------------------------------------------
  
  public function view_qpaper_questions(Request $request)  //for analytics
  {
	 if ($request->ajax()) {
            $data = (new McqQuestion())->get_qpaper_questions($request);
            return DataTables::of($data)
				->addIndexColumn()
				/*->addColumn('selbtn',function($data)
				{
					//return '<input type="checkbox" class="sub_chk" data-id="'.$data['id'].'" style="width:20px;height:20px;" ></label>';
					return  '<button type="button" class="qselect btn btn-primary btn-sm" title="Select Question" style="padding: 5px 10px 5px 10px;"><i class="fa fa-check"></i></button>';
				})*/
				->rawColumns(['action','quest','qmode'])
				->make(true);
        }
  }
  
  
  public function get_question_papers($id)
  {
	  $res=(new McqQuestionPaper())->getQuestionPaperByCourseId($id);
	  $opt="<option value=''>--Select Question Paper--</option>";
	  if(!empty($res))
	  {
		  foreach($res as $r)
		  {
			  $opt.="<option value='".$r->id."'>".$r->question_paper_name."</option>";
		  }
	  }
	  echo $opt;
  }
 
  
  public function get_attendees(Request $request)
  {
	 if ($request->ajax()) {
            $data = (new McqTestAllResult())->get_attendees_list($request);

            return DataTables::of($data)
				->addIndexColumn()
				/*->addColumn('selbtn',function($data)
				{
					//return '<input type="checkbox" class="sub_chk" data-id="'.$data['id'].'" style="width:20px;height:20px;" ></label>';
					return  '<button type="button" class="qselect btn btn-primary btn-sm" title="Select Question" style="padding: 5px 10px 5px 10px;"><i class="fa fa-check"></i></button>';
				})*/
				->rawColumns(['answer'])
				->make(true);
        }
  }
  
  
  public function get_attendees_total($qid)
  {
	   $data = (new McqTestAllResult())->get_attendees_total($qid);
	   echo $data;
  }
  
  
  
}
