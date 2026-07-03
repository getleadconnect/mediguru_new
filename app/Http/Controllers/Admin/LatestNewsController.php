<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\LatestNews;
use App\Models\Course;
use App\Models\McqTestResult;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class LatestNewsController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $crs = (new Course())->getCourses(); 
	return view('admin.latest_news.latest_news',compact('crs'));
  }

  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),LatestNews::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new LatestNews())->addLatestNews($request);
		   
			if($result)
			{
				Session::flash('message', 'success#LatestNews successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('latest_news');
	}
	
	
	public function edit($id)
	{
		$crs=(new Course())->getCourses();
		$ln=(new LatestNews())->getLatestNewsById($id);
		$subj=(new Subject())->getSubjectsByCourseId($ln->course_id);
		return view('admin.latest_news.edit_latest_news',compact('crs','subj','ln'));
	}
	
	
	 public function update_latest_news(Request $request)
	 {

		$validate=Validator::make($request->all(),LatestNews::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing-11, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new LatestNews())->updateLatestNews($request);

			if($result)
			{
				Session::flash('message', 'success#Latest news successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing-22, try again.');
			}				

			return redirect('latest_news');
	}
  
    public function view_data(Request $request)
	{
		
		//$qpid=$request->searchByQpaper;
		
		if ($request->ajax()) {
            $data = (new LatestNews())->viewLatestNews($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['cname','icon','title','desc','action','status'])
                    ->make(true);
        }
	}
  
  public function get_more_latest_news($id)  //modal content
  {
	  $res=LatestNews::where('id',$id)->first();
	  $dat="";
	  if(!empty($res))
	  {
		  $dat=$res->description;
	  }
	  
	  return $dat;
	  
  }
    
  
  
   public function destroy($id)
	{

		$result=(new LatestNews())->deleteLatestNews($id);
		Session::flash('message', 'success#'.$result);
		
		if($result)
		{
			//Session::flash('message', 'success#LatestNews successfully removed.');
			$res="News successfully removed.";
		}
		else
		{
			//Session::flash('message', 'danger#Something wrong, try again.');
			$res="Something wrong, try again.";
		}			

		return $res;
	}
	
	
	public function activate_deactivate_news($op,$id)
	{
		
		if($op==1)
		{
			$res=['status'=>1];
		}
		else
		{
			$res=['status'=>2];
		}

		$result=LatestNews::whereId($id)->update($res);
		
			if($result)
			{
				if($op==1)
				{
					$res="News successfully activated.";
				}
				else
				{
					$res="News successfully deactivated.";
				}
			}
			else
			{
				$res="Deatils missing, try agin.";
			}				

			return $res;
	}
	
	
	
	/*public function get_rank($qid)
	{
		$qpid=$qid;
		$rank_list=McqTestResult::select('student_id','score')->where('question_paper_id',$qpid)->get()->toArray();
			
			//$rank_list=array();
			$last_v=0;$i=0;
			usort($rank_list,array($this,'sortByMark'));
			
				foreach ($rank_list as $m => $v) 
				{
						if ($v['score'] != $last_v)
						{
						   $i++;
						   $last_v = $v['score'];
						}
					  $rank_list[$m]['student_id'] = $v['student_id'];
					  $rank_list[$m]['rank'] = $i;
				}
			
			$key = array_search('52', array_column($rank_list, 'student_id'));
			//------------------------------
			if($key=="" or $key==null){$key=0;$my_rank=0;}
			
			if(!empty($rank_list))
			{
			   $my_rank=$rank_list[$key]['rank'];
			}

	}		
	
	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}
	*/
	
	
}
