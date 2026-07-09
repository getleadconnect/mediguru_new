<?php

namespace App\Http\Controllers\Api\v3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Str;

use App\Models\Course;
use App\Models\Subject;
use App\Models\McqQuestionPaper;
use App\Models\McqQuestion;
use App\Models\DashLiveMockTest;

use App\Models\McqResult;
use App\Models\McqAllResult;
use App\Models\McqTestResult;
use App\Models\McqTestAllResult;
use App\Models\McqEmdResult;

use App\Models\Package;
use App\Models\PurchasedPackage;
use App\Models\LessonLiveTest;


class LiveMcqController extends Controller
{
	
	 /**
	 * Function get_question_papers
	 * Function to get subject based question papers
	 * Method:POST
	 * @params: subject_id
	 * return [ quetsion papers ]
	 */
	
	
   public function get_live_question_papers(Request $request) 
	{
		
		$sid=$request->subject_id;
		$lid=$request->lesson_id;
		
		$where1=['subject_id'=>$sid,'question_paper_type'=>2,'status'=>1];
		
		$lmtcount=McqQuestionPaper::where($where1)->count();
		$testdt=['total_test'=>$lmtcount];
				
		$where1=['subject_id'=>$sid,'question_paper_type'=>2,'status'=>1];
		$data = McqQuestionPaper::where($where1)->orderBy('id','ASC')->get();
				
	    if(!$data->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'data'=>$data,
				'image_path'=>config('constants.image_path'),
			];
			return response($response, 200);
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
			return response($response, 200);
		}
		
    }


	/**
	  * Function get_questions
	  * Function to get questions based specified question paper
	  * Method:POST
	  * @params: question_paper_id
	  * return [ quetsions ]
	*/
   
   public function get_live_questions(Request $request) 
	{
	
		$qpid=$request->question_paper_id;
		
		$data = McqQuestion::where('Question_paper_id',$qpid)->orderBy('id','ASC')->get();
		 
	    if(!$data->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'comments'=>"Question_Mode[1-easy/2-medium/3-dificult], Qusetion_Type[1-text/2-image]",
				'question'=>$data,
				'image_path'=>config('constants.image_path'),
			];
			return response($response, 200);
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
			return response($response, 200);
		}
    }



   /**
	 * Function set_mcq_results
	 * Function to set the mock test questions  result of specified question paper
	 * Methiod: POST
	 * @param subject_id, mcq_question_paper_id,student_id int
	 
	 * @param test_result json
		test_result : {"mcq_result":[{"question_id":"1","answer":"3"},{"question_id":"2","answer":"4"},
		{"question_id":"3","answer":"2"},{"question_id":"4","answer":"3"},
		{"question_id":"5","answer":"4"}]}
	 * return [ questions ]
	 */
		
	public function set_live_mcq_results(Request $request) 
	{

		$tdate=date('Y-m-d');
		$qpid=$request->mcq_question_paper_id;
		$stid=$request->student_id;
		$subid=$request->subject_id;
		$tresult=$request->test_result;
		$ttime=$request->total_time;
		
		$answer=0;
		$wrong=0;
		$skipped=0;		
		$qcount=0;
				
		$arr = json_decode($tresult,true);
				
		//delete existing result ------------------------
		$where=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid,'subject_id'=>$subid];
		McqTestAllResult::where($where)->delete();
		//----------------------------------------------
		    $tot_easy=0;
			$tot_med=0;
			$tot_dif=0;
				
			$tot_e_c=0;	$tot_e_w=0;	$tot_e_s=0; 
			$tot_m_c=0;	$tot_m_w=0; $tot_m_s=0;	
			$tot_d_c=0;	$tot_d_w=0;	$tot_d_s=0;		
		
		$qcount=McqQuestion::where("mcq_question_paper_id",$qpid)->count(); 
				
		foreach ($arr['mcq_result'] as $pt)
		{		
			$mtquestid=$pt['question_id'];
			$mtanswer=$pt['answer'];
			
			$mqres=McqQuestion::find($mtquestid); 		
			
			//insert question and result ------------------------
			$mar=McqTestAllResult::create(['result_date'=>date('Y-m-d'),
			'subject_id'=>$subid,
			'student_id'=>$stid,
			'mcq_question_paper_id'=>$qpid,
			'question_id'=>$mtquestid,
			'question_mode'=>$mqres->question_mode,
			'question_type'=>$mqres->question_type,
			'correct_answer'=>$mqres->correct_answer,
			'answer'=>$mtanswer
			]);
			//-------------------------------------------

			//$qcount++;
			
			$res=McqQuestion::whereId($mtquestid)->get()->toArray();

			if($mtanswer==0)
			{
				$skipped++;
				if($res[0]['question_mode']==1)
					{
						$tot_easy++;
						$tot_e_s++;
					}
					if($res[0]['question_mode']==2)
					{
						$tot_med++;
						$tot_m_s++;
					}
					if($res[0]['question_mode']==3)
					{
						$tot_dif++;
						$tot_d_s++;
					}
			}
			else
			{
		
				if($res[0]['correct_answer']==$mtanswer)
				{
					$answer++;
					
					if($res[0]['question_mode']==1)
					{
						$tot_easy++;
						$tot_e_c++;
					}
					if($res[0]['question_mode']==2)
					{
						$tot_med++;
						$tot_m_c++;
					}
					if($res[0]['question_mode']==3)
					{
						$tot_dif++;
						$tot_d_c++;
					}
	
				}
				else
				{
					$wrong++;
					
					if($res[0]['question_mode']==1)
					{
						$tot_easy++;
						$tot_e_w++;
					}
					if($res[0]['question_mode']==2)
					{
						$tot_med++;
						$tot_m_w++;
					}
					if($res[0]['question_mode']==3)
					{
						$tot_dif++;
						$tot_d_w++;
					}
					
				}
			}
		}
		
		//delete old result ---------
		$prec=McqTestResult::where('subject_id',$subid)->where('student_id',$stid)->where('mcq_question_paper_id',$qpid);
		$prec->delete();
		
		//--------------------------
		
		$m=1;$n=1;
		
		//$mr=Subject::where('id',$subid)->first(); 

		$mr=McqQuestionPaper::where('id',$qpid)->first();

		if(!empty($mr)){$m=$mr->question_mark; $n=$mr->negative_mark;}
				
			$mark=$answer*$m;
			$neg=($wrong*$n);
			$score=$mark-$neg;
			
			$res1=McqTestResult::create([
				'test_date'=>date('Y-m-d'),
				'mcq_question_paper_id'=>$qpid,   
				'subject_id'=>$subid,
				'student_id'=>$stid,
				'total_questions'=>$qcount,
				'answer'=>$answer,
				'wrong'=>$wrong,
				'skipped'=>$skipped,
				'marks'=>$mark."/".($qcount*$m),
				'negative'=>$neg,
				'score'=>(float)$score,
				'total_time'=>$ttime,
				'status'=>"1",
			]);
			
			
			$res2=McqAllResult::create([
				'test_date'=>date('Y-m-d'),
				'mcq_question_paper_id'=>$qpid,   
				'subject_id'=>$subid,
				'student_id'=>$stid,
				'total_questions'=>$qcount,
				'answer'=>$answer,
				'wrong'=>$wrong,
				'skipped'=>$skipped,
				'marks'=>$mark."/".($qcount*$m),
				'negative'=>$neg,
				'score'=>(float)$score,
				'total_time'=>$ttime,
				'status'=>"1",
			]);
			
							
			$ins_id=$res1->id;

		if($ins_id>0)
		{

			$res1=['questions'=>$qcount,
				'correct'=>$answer,
				'wrong'=>$wrong,
				'skipped'=>$skipped,
				//'negtive'=$neg;
				'score'=>(float)$score,
				];
			
			$esy=['easy_total'=>$tot_easy,
				'easy_correct'=>$tot_e_c,
				'easy_wrong'=>$tot_e_w,
				'easy_skip'=>$tot_e_s,
				];
					
			$med=['med_total'=>$tot_med,
				'med_correct'=>$tot_m_c,
				'med_wrong'=>$tot_m_w,
				'med_skip'=>$tot_m_s,
				];
			$dif=['dif_total'=>$tot_dif,
				'dif_correct'=>$tot_d_c,
				'dif_wrong'=>$tot_d_w,
				'dif_skip'=>$tot_d_s,
				];
				
		//remove existing esay,medium,difficult results ------------------------
		 $where=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid, 'subject_id'=>$subid];
		 $mcqr=McqEmdResult::where($where)->delete();  
		//----------------------------------------------
		 $emd_result=McqEmdResult::create([
					'student_id'=>$stid,
					'subject_id'=>$subid,
					'mcq_question_paper_id'=>$qpid,
					'easy_total'=>$tot_easy,
					'easy_correct'=>$tot_e_c,
					'easy_wrong'=>$tot_e_w,
					'easy_skip'=>$tot_e_s,
					'medium_total'=>$tot_med,
					'medium_correct'=>$tot_m_c,
					'medium_wrong'=>$tot_m_w,
					'medium_skip'=>$tot_m_s,
					'difficult_total'=>$tot_dif,
					'difficult_correct'=>$tot_d_c,
					'difficult_wrong'=>$tot_d_w,
					'difficult_skip'=>$tot_d_s,
					]);

				
			//get for rank position---------
			
			$rank_list=McqTestResult::select('student_id','score')->where('mcq_question_paper_id',$qpid)->get()->toArray();

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
			
			$key = array_search($v['student_id'], array_column($rank_list, 'student_id'));
			//------------------------------
			if($key=="" or $key==null){$key=0;$my_rank=0;}
			
			if(!empty($rank_list))
			{
			   $my_rank=$rank_list[$key]['rank'];
			}
			
			if(!empty($res1))
			{
				if($res1['score']==0)
				{
					$rnk=['my_rank'=>"Your Rank is "."0/".count($rank_list)];
				}
				else
				{		
					$rnk=['my_rank'=>"Your Rank is ".($my_rank)."/".count($rank_list)];
				}
			}
			else
			{
				$rnk=['my_rank'=>"Your Rank is "."0/".count($rank_list)];
			}

			
			$response=[
			   'status'=>TRUE,
			   'result'=>$res1,
			   'easy'=>$esy,
			   'medium'=>$med,
			   'difficult'=>$dif,
			   'rank'=>$rnk,
			   'message'=>"Test result successfully added",
			];		

		}
		else{
			$response = ['status'=>FALSE, "message" => "Error, Please try again."];
		}	

		return response($response, 200);
    }
	
	
	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}

	
		 /**
	 * Function get_mcq_results
	 * Function to get the existing mcq result and analytics
	 * Method:POST
	 * @params: student_id,subject_id,mcq_question_paper_id
	 * return [ list ]
	 */
		
	
	public function get_live_mcq_results(Request $request) 
	{

		$qpid=$request->mcq_question_paper_id;
		$stid=$request->student_id;
		$subid=$request->subject_id;
		
		//$where=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid, 'subject_id'=>$subid];
		$where=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid];
		$mcqres=McqTestResult::where($where)->get()->first();
		
		$res1=["questions"=>0,"correct" =>0,"wrong"=>0,"skipped"=>0,"score"=>0,'total_time'=>0];
		
		if(!empty($mcqres))
		{
		
		$qcount=explode("/",$mcqres->marks);
			
		  $res1=["questions"=>intVal($qcount[1]),
				"correct" =>$mcqres->answer,
				"wrong"=>$mcqres->wrong,
				"skipped"=>$mcqres->skipped,
				"score"=>$mcqres->score,
				"total_time"=>$mcqres->total_time,
			];
		}
		
		//$where1=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid, 'subject_id'=>$subid];
		$where1=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid];
		$eres=McqEmdResult::where($where1)->get()->first();
		
		$esy=['easy_total'=>0,'easy_correct'=>0,'easy_wrong'=>0,'easy_skip'=>0];
		$med=['med_total'=>0,'med_correct'=>0,'med_wrong'=>0,'med_skip'=>0];
		$dif=['dif_total'=>0,'dif_correct'=>0,'dif_wrong'=>0,'dif_skip'=>0];	
		
		if(!empty($eres))
		{
			$esy=['easy_total'=>$eres->easy_total,
				'easy_correct'=>$eres->easy_correct,
				'easy_wrong'=>$eres->easy_wrong,
				'easy_skip'=>$eres->easy_skip,
				];
					
			$med=['med_total'=>$eres->medium_total,
				'med_correct'=>$eres->medium_correct,
				'med_wrong'=>$eres->medium_wrong,
				'med_skip'=>$eres->medium_skip,
				];
				
			$dif=['dif_total'=>$eres->difficult_total,
				'dif_correct'=>$eres->difficult_correct,
				'dif_wrong'=>$eres->difficult_wrong,
				'dif_skip'=>$eres->difficult_skip,
				];
		  }

		//get for rank position---------
			
			$rank_list=McqTestResult::select('student_id','score')->where('mcq_question_paper_id',$qpid)->get()->toArray();

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
			
			$key = array_search($stid, array_column($rank_list, 'student_id'));

			//------------------------------
			if($key=="" or $key==null){$key=0;$my_rank=0;}
			
			if(!empty($rank_list))
			{
			   $my_rank=$rank_list[$key]['rank'];
			}
			
			if(!empty($res1))
			{
				if($res1['score']==0)
				{
					$rnk=['my_rank'=>"Your Rank is "."0/".count($rank_list)];
				}
				else
				{		
					$rnk=['my_rank'=>"Your Rank is ".($my_rank)."/".count($rank_list)];
				}
			}
			else
			{
				$rnk=['my_rank'=>"Your Rank is "."0/".count($rank_list)];
			}
			
			//$rnk=['my_rank'=>"Your Rank is ".($my_rank)."/".count($rank_list)];
			//-----------------------------------------------

			$response=[
			'status'=>TRUE,
			'result'=>$res1,
			'easy'=>$esy,
			'medium'=>$med,
			'difficult'=>$dif,
			'rank'=>$rnk,
			'message'=>"Test result successfully added",
			];		
		
		return response($response, 200);
		
    }

		 /**
	 * Function get_mcq_analytics
	 * Function to get the attend question papaers analytics
	 * Method:POST
	 * @params: student_id
	 * return [ quetsions ]
	 */
   
   public function get_live_mcq_analytics(Request $request) 
	{
		$stid=$request->student_id;
		$crs_id=$request->course_id;
		
		$mres= McqTestResult::select('mcq_test_results.*','mcq_question_papers.id as qpaper_id','mcq_question_papers.question_paper_name')
		->leftJoin('mcq_question_papers','mcq_test_results.mcq_question_paper_id','=','mcq_question_papers.id')
		->leftJoin('courses','mcq_question_papers.course_id','=','courses.id')
		->where('mcq_test_results.student_id',$stid)->where('courses.id',$crs_id)
		->orderBy('mcq_test_results.id','ASC')->get();
		
		$x=0;
		foreach($mres as $r)
		{
			$qcount=McqTestResult::where('mcq_question_paper_id',$r->qpaper_id)->count();
			$mres[$x]['attended_count']=$qcount;
			$x++;
		}
		
	    if(!$mres->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'analytics'=>$mres,
			];
			return response($response, 200);
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
			return response($response, 200);
		}
    }
	
//--------------lesson live mocktests------------------------------------------------------------------------------------------	
	
	/**
	 * Function get_live_classes
	 * Function to get the live class details
	 * Method:POST
	 * @params: stduent_id
	 * return [ details ]
	 */

public function get_live_mock_tests(Request $request)  //live class for dashboard
{
	$stid=$request->student_id;
	
	$psubids=Package::select('subject_id')
		->whereIn('id',PurchasedPackage::select('package_id')
		->where('student_id',$stid))->get();

		$sbjids='';
		foreach($psubids as $r)
		{
			$sbjids.=','.$r->subject_id;
		}
		
		$sbjids=substr($sbjids,1);
		$sbj_ids=explode(",",$sbjids);
		$sbjids=array_unique($sbj_ids);
		
		$liv_cls=LessonLiveTest::select('lesson_live_tests.live_unique_id as unique_id','mcq_question_papers.id','mcq_question_papers.test_date','mcq_question_papers.start_time','mcq_question_papers.start_time_text','mcq_question_papers.question_paper_name')	->leftJoin('mcq_question_papers','lesson_live_tests.live_unique_id','=','mcq_question_papers.unique_id')
		->whereIn('lesson_live_tests.subject_id',$sbjids)->where('mcq_question_papers.test_date','>=',date('Y-m-d'))
		->where('mcq_question_papers.status',1)->orderBy('test_date','DESC')->get();
				
		$response = [
			'status'=>TRUE,
			'data'=>$liv_cls,
		];
	return response($response, 200);	
}


//--------------dashboard live mock tests------------------------------------------------------------------------------------------	
	
	/**
	 * Function get_dash_live_mock_tests
	 * Function to get the dashboard live mock tests details
	 * Method:POST
	 * @params: student_id
	 * return [ details ]
	 */


public function get_dash_live_mock_tests(Request $request)  //live class for dashboard
{
	$stid=$request->student_id;
	
	$psubids=Package::select('subject_id')
		->whereIn('id',PurchasedPackage::select('package_id')
		->where('student_id',$stid))->get();

		$sbjids='';
		foreach($psubids as $r)
		{
			$sbjids.=','.$r->subject_id;
		}
		
		$sbjids=substr($sbjids,1);
		$sbj_ids=explode(",",$sbjids);
		$sbjids=array_unique($sbj_ids);
		
		$start_date=date('Y-m-d');
		$end_date=$NewDate = date('Y-m-d', strtotime($start_date . " +7 days")); 
		
		$lmtests=McqQuestionPaper::select('mcq_question_papers.*')
		->leftJoin('dash_live_mock_tests','mcq_question_papers.unique_id','=','dash_live_mock_tests.live_unique_id')
		->whereIn('dash_live_mock_tests.subject_id',$sbjids)
		->where('mcq_question_papers.question_paper_type',2)->where('mcq_question_papers.status',1)
		->where('mcq_question_papers.test_date','>=',$start_date)->where('mcq_question_papers.test_date','<=',$end_date)
		->orderBy('mcq_question_papers.test_date','ASC')->get();

		$response = [
			'status'=>TRUE,
			'data'=>$lmtests,
		];
		
	return response($response, 200);	
}



   /**
	 * Function set_dash_live_mcq_results
	 * Function to set the mock test questions  result of specified question paper
	 * Methiod: POST
	 * @param subject_id, mcq_question_paper_id,student_id int
	 
	 * @param test_result json
		test_result : {"mcq_result":[{"question_id":"1","answer":"3"},{"question_id":"2","answer":"4"},
		{"question_id":"3","answer":"2"},{"question_id":"4","answer":"3"},
		{"question_id":"5","answer":"4"}]}
	 * return [ questions ]
	 */
		
	public function set_dash_live_mcq_results(Request $request) 
	{

		$tdate=date('Y-m-d');
		$qpid=$request->mcq_question_paper_id;
		$stid=$request->student_id;
		$tresult=$request->test_result;
		$ttime=$request->total_time;
		
		$answer=0;
		$wrong=0;
		$skipped=0;		
		$qcount=0;
				
		$arr = json_decode($tresult,true);
				
		//delete existing result ------------------------
		$where=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid];
		McqTestAllResult::where($where)->delete();
		//----------------------------------------------
		    $tot_easy=0;
			$tot_med=0;
			$tot_dif=0;
				
			$tot_e_c=0;	$tot_e_w=0;	$tot_e_s=0; 
			$tot_m_c=0;	$tot_m_w=0; $tot_m_s=0;	
			$tot_d_c=0;	$tot_d_w=0;	$tot_d_s=0;		
				
		foreach ($arr['mcq_result'] as $pt)
		{		
			$mtquestid=$pt['question_id'];
			$mtanswer=$pt['answer'];
			
			$mqres=McqQuestion::find($mtquestid); 		
			
			//insert question and result ------------------------
			$mar=McqTestAllResult::create(['result_date'=>date('Y-m-d'),
			'subject_id'=>null,
			'student_id'=>$stid,
			'mcq_question_paper_id'=>$qpid,
			'question_id'=>$mtquestid,
			'question_mode'=>$mqres->question_mode,
			'question_type'=>$mqres->question_type,
			'correct_answer'=>$mqres->correct_answer,
			'answer'=>$mtanswer
			]);
			//-------------------------------------------

			$qcount++;
			
			$res=McqQuestion::whereId($mtquestid)->get();

			if($mtanswer==0)
			{
				$skipped++;
				if($res[0]['question_mode']==1)
					{
						$tot_easy++;
						$tot_e_s++;
					}
					if($res[0]['question_mode']==2)
					{
						$tot_med++;
						$tot_m_s++;
					}
					if($res[0]['question_mode']==3)
					{
						$tot_dif++;
						$tot_d_s++;
					}
			}
			else
			{
		
				if($res[0]['correct_answer']==$mtanswer)
				{
					$answer++;
					
					if($res[0]['question_mode']==1)
					{
						$tot_easy++;
						$tot_e_c++;
					}
					if($res[0]['question_mode']==2)
					{
						$tot_med++;
						$tot_m_c++;
					}
					if($res[0]['question_mode']==3)
					{
						$tot_dif++;
						$tot_d_c++;
					}
	
				}
				else
				{
					$wrong++;
					
					if($res[0]['question_mode']==1)
					{
						$tot_easy++;
						$tot_e_w++;
					}
					if($res[0]['question_mode']==2)
					{
						$tot_med++;
						$tot_m_w++;
					}
					if($res[0]['question_mode']==3)
					{
						$tot_dif++;
						$tot_d_w++;
					}
					
				}
			}
		}
		
		//delete old result ---------
		$prec=McqTestResult::where('student_id',$stid)->where('mcq_question_paper_id',$qpid);
		$prec->delete();
		
		$mar=McqAllResult::where('student_id',$stid)->where('mcq_question_paper_id',$qpid);
		$mar->delete();
		//--------------------------
		
		$m=1;$n=1;

		/*$mc=McqQuestionPaper::select('unique_id')->where('id',$qpid)->first();
		if(!empty($mc))
		{
			$mr=Subject::whereIn('id',DashLiveMockTest::select(['subject_id'])->where('live_unique_id',$mc->unique_id))->first();
			if(!empty($mr)){$m=$mr->question_mark; $n=$mr->negative_mark;}
		}*/

		$mc=McqQuestionPaper::where('id',$qpid)->first();
		if(!empty($mc)){$m=$mc->question_mark; $n=$mc->negative_mark;}
		
			$mark=$answer*$m;
			$neg=($wrong*$n);
			$score=$mark-$neg;
			
			$res1=McqTestResult::create([
				'test_date'=>date('Y-m-d'),
				'mcq_question_paper_id'=>$qpid,   
				'subject_id'=>null,
				'student_id'=>$stid,
				'total_questions'=>$qcount,
				'answer'=>$answer,
				'wrong'=>$wrong,
				'skipped'=>$skipped,
				'marks'=>$mark."/".($qcount*$m),
				'negative'=>$neg,
				'score'=>(float)$score,
				'total_time'=>$ttime,
				'status'=>"1",
			]);
			
			
			$res2=McqAllResult::create([
				'test_date'=>date('Y-m-d'),
				'mcq_question_paper_id'=>$qpid,   
				'subject_id'=>null,
				'student_id'=>$stid,
				'total_questions'=>$qcount,
				'answer'=>$answer,
				'wrong'=>$wrong,
				'skipped'=>$skipped,
				'marks'=>$mark."/".($qcount*$m),
				'negative'=>$neg,
				'score'=>(float)$score,
				'total_time'=>$ttime,
				'status'=>"1",
			]);
			
							
			$ins_id=$res1->id;

		if($ins_id>0)
		{

			$res1=['questions'=>$qcount,
				'correct'=>$answer,
				'wrong'=>$wrong,
				'skipped'=>$skipped,
				//'negtive'=$neg;
				'score'=>(float)$score,
				];
			
			$esy=['easy_total'=>$tot_easy,
				'easy_correct'=>$tot_e_c,
				'easy_wrong'=>$tot_e_w,
				'easy_skip'=>$tot_e_s,
				];
					
			$med=['med_total'=>$tot_med,
				'med_correct'=>$tot_m_c,
				'med_wrong'=>$tot_m_w,
				'med_skip'=>$tot_m_s,
				];
			$dif=['dif_total'=>$tot_dif,
				'dif_correct'=>$tot_d_c,
				'dif_wrong'=>$tot_d_w,
				'dif_skip'=>$tot_d_s,
				];
				
		//remove existing esay,medium,difficult results ------------------------
		 $where=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid];
		 $mcqr=McqEmdResult::where($where)->delete();  
		//----------------------------------------------
		 $emd_result=McqEmdResult::create([
					'student_id'=>$stid,
					'subject_id'=>null,
					'mcq_question_paper_id'=>$qpid,
					'easy_total'=>$tot_easy,
					'easy_correct'=>$tot_e_c,
					'easy_wrong'=>$tot_e_w,
					'easy_skip'=>$tot_e_s,
					'medium_total'=>$tot_med,
					'medium_correct'=>$tot_m_c,
					'medium_wrong'=>$tot_m_w,
					'medium_skip'=>$tot_m_s,
					'difficult_total'=>$tot_dif,
					'difficult_correct'=>$tot_d_c,
					'difficult_wrong'=>$tot_d_w,
					'difficult_skip'=>$tot_d_s,
					]);

			//get for rank position---------
			
			$rank_list=McqTestResult::select('student_id','score')->where('mcq_question_paper_id',$qpid)->get()->toArray();

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
			
			$rnk=['my_rank'=>"Your Rank is ".($my_rank)."/".count($rank_list)];
			//-----------------------------------------------

			
			$response=[
			   'status'=>TRUE,
			   'result'=>$res1,
			   'easy'=>$esy,
			   'medium'=>$med,
			   'difficult'=>$dif,
			   'rank'=>$rnk,
			   'message'=>"Test result successfully added",
			];		

		}
		else{
			$response = ['status'=>FALSE, "message" => "Error, Please try again."];
		}	

		return response($response, 200);
    }
	
	public function sortBy_Mark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}

	
		 /**
	 * Function get_mcq_results
	 * Function to get the existing mcq result and analytics
	 * Method:POST
	 * @params: student_id,subject_id,mcq_question_paper_id
	 * return [ list ]
	 */
		
	
	public function get_dash_live_mcq_results(Request $request) 
	{

		$qpid=$request->mcq_question_paper_id;
		$stid=$request->student_id;
		
		$where=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid];
		$mcqres=McqTestResult::where($where)->get()->first();
		
		$res1=["questions"=>0,"correct" =>0,"wrong"=>0,"skipped"=>0,"score"=>0,'total_time'=>0];
		
		if(!empty($mcqres))
		{
		
		$qcount=explode("/",$mcqres->marks);
			
		  $res1=["questions"=>$qcount[1],
				"correct" =>$mcqres->answer,
				"wrong"=>$mcqres->wrong,
				"skipped"=>$mcqres->skipped,
				"score"=>$mcqres->score,
				"total_time"=>$mcqres->total_time,
			];
		}
		
		
		$where1=["mcq_question_paper_id"=>$qpid,'student_id'=>$stid];
		$eres=McqEmdResult::where($where1)->get()->first();
		
		$esy=['easy_total'=>0,'easy_correct'=>0,'easy_wrong'=>0,'easy_skip'=>0];
		$med=['med_total'=>0,'med_correct'=>0,'med_wrong'=>0,'med_skip'=>0];
		$dif=['dif_total'=>0,'dif_correct'=>0,'dif_wrong'=>0,'dif_skip'=>0];	
		
		if(!empty($eres))
		{
			$esy=['easy_total'=>$eres->easy_total,
				'easy_correct'=>$eres->easy_correct,
				'easy_wrong'=>$eres->easy_wrong,
				'easy_skip'=>$eres->easy_skip,
				];
					
			$med=['med_total'=>$eres->medium_total,
				'med_correct'=>$eres->medium_total,
				'med_wrong'=>$eres->medium_total,
				'med_skip'=>$eres->medium_total,
				];
				
			$dif=['dif_total'=>$eres->difficult_total,
				'dif_correct'=>$eres->difficult_total,
				'dif_wrong'=>$eres->difficult_total,
				'dif_skip'=>$eres->difficult_total,
				];
		  }

		//get for rank position---------
			
			$rank_list=McqTestResult::select('student_id','score')->where('mcq_question_paper_id',$qpid)->get()->toArray();

			$last_v=0;$i=0;
			usort($rank_list,array($this,'sortBy_Mark'));
			
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
			
			$key = array_search($stid, array_column($rank_list, 'student_id'));

			//------------------------------
			if($key=="" or $key==null){$key=0;$my_rank=0;}
			
			if(!empty($rank_list))
			{
			   $my_rank=$rank_list[$key]['rank'];
			}
			
			$rnk=['my_rank'=>"Your Rank is ".($my_rank)."/".count($rank_list)];
			//-----------------------------------------------

			$response=[
			'status'=>TRUE,
			'result'=>$res1,
			'easy'=>$esy,
			'medium'=>$med,
			'difficult'=>$dif,
			'rank'=>$rnk,
			'message'=>"Test result successfully added",
			];		
		
		return response($response, 200);
		
    }

		 /**
	 * Function get_mcq_analytics
	 * Function to get the attend question papaers analytics
	 * Method:POST
	 * @params: student_id
	 * return [ quetsions ]
	 */
   
   public function get_dash_live_mcq_analytics(Request $request) 
	{
		$stid=$request->student_id;
		$crs_id=$request->course_id;
		
		$mres= McqTestResult::select('mcq_test_results.*','mcq_question_papers.id as qpaper_id','mcq_question_papers.question_paper_name')
		->leftJoin('mcq_question_papers','mcq_test_results.mcq_question_paper_id','=','mcq_question_papers.id')
		->leftJoin('courses','mcq_question_papers.course_id','=','courses.id')
		->where('mcq_test_results.student_id',$stid)->where('courses.id',$crs_id)
		->orderBy('mcq_test_results.id','ASC')->get();
		
		$x=0;
		foreach($mres as $r)
		{
			$qcount=McqTestResult::where('mcq_question_paper_id',$r->qpaper_id)->count();
			$mres[$x]['attended_count']=$qcount;
			$x++;
		}
		
	    if(!$mres->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'analytics'=>$mres,
			];
			return response($response, 200);
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
			return response($response, 200);
		}
    }
	
}
