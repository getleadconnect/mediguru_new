<?php

namespace App\Http\Controllers\Api\v3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

use App\Models\State;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\Subject;
use App\Models\UserHiddenCourse;

use App\Models\DashboardBanner;
use App\Models\Package;
use App\Models\PurchasedPackage;
use App\Models\Promocode;
use App\Models\Staff;

use App\Models\McqQuestion;
use App\Models\McqQuestionPaper;
use App\Models\McqTestResult;
use App\Models\McqTestAllResult;

use App\Models\Lesson;
use App\Models\LessonVideo;
use App\Models\LessonMcqTest;
use App\Models\LessonMaterial;
use App\Models\LessonLiveTest;

use App\Models\Video;
use App\Models\Material;
use App\Models\LatestNews;
use App\Models\SubjectLiveClass;

use App\Models\MaterialLike;
use App\Models\MaterialComment;
use App\Models\GeneralFeedback;

use App\Models\Notification;
use App\Models\ChatData;
use App\Models\SocialMedia;
use App\Models\Student;
use App\Models\User;

use App\Models\SharedSubject;


class GeneralController extends Controller
{
	
   /**
	 * Function get_states
	 * Function to list states
	 * Method:GET
	 * @param: mone
	 * return [ states]
	 */

   public function get_states() 
	{
		$sts = State::orderBy('id','ASC')->get();
		 
	    if(!$sts->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'states'=>$sts,
			];
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
		}
		
		return response($response, 200);
    }	
	
/**
 * Function get_courses
 * Function to list courses
 * Method:GET
 * @param: mone
 * return [ courses]
 */
	 
 // include social media links for navigation bar

   public function get_courses(Request $request) 
	{
		
		$stid=$request->student_id;
		
		$crs1 = Course::select('courses.*')->where('course_type',0)->where('status',1)->get()->toArray();
		$crs2=Course::select('courses.*')->whereIn('unique_id',UserHiddenCourse::select(['course_unique_id'])
		->where('student_id',$stid))->where('status',1)->get()->toArray();
				
		if(!empty($crs2))
		{
			$crs1 = array_merge($crs1,$crs2);
		}
				
		//$crs=$crs->sortBy('reorder_no');
		
		array_multisort(array_column($crs1, 'reorder_no'), SORT_ASC, $crs1);
		
		$social = SocialMedia::orderBy('id','ASC')->get(); 					 //navigation bar  scial meadia items 
		
		$bnr = DashboardBanner::where('banner_section',1)->get()->first();
		$bnr_image=(!empty($bnr))?$bnr_image=$bnr->banner_image:'';
		

		foreach($crs1 as $key=>$r)
		{
			$pkt=Package::select('package_type','rate','rate_6_months','rate_3_months','ios_rate','ios_6_months','ios_3_months')
				->whereIn('id',PurchasedPackage::select('package_id')
				->where('course_unique_id',$r['unique_id'])->where('student_id',$stid))->first();
				
			if(!empty($pkt)) {
			    $crs1[$key]['purchase_status']=($pkt->package_type==1)?1:2;
			}
			else
			{
				$crs1[$key]['purchase_status']=0;
			}

			$pkt1=Package::select('rate','rate_6_months','rate_3_months','ios_rate','ios_6_months','ios_3_months')->where('course_unique_id',$r['unique_id'])
			->where('package_type',1)->first();	
			
			if(!empty($pkt1)) { 
				$crs1[$key]['package_rate']=$pkt1->rate;
				$crs1[$key]['rate_6_months']=$pkt1->rate_6_months;
				$crs1[$key]['rate_3_months']=$pkt1->rate_3_months;
				$crs1[$key]['package_ios_rate']=$pkt1->ios_rate;
				$crs1[$key]['ios_6_months']=$pkt1->ios_6_months;
				$crs1[$key]['ios_3_months']=$pkt1->ios_3_months;
			}	
			else{ 
				$crs1[$key]['package_rate']=0;
				$crs1[$key]['rate_6_months']=0;
				$crs1[$key]['rate_3_months']=0;
				$crs1[$key]['package_ios_rate']=0;
				$crs1[$key]['ios_6_months']=0;
				$crs1[$key]['ios_3_months']=0;
			}

		}
	
	    if(!empty($crs1)) 
		{
			$response = [
				'status'=>TRUE,
				'comment'=>'purchase_status, 0-null, 1-Full, 2-Subject',
				'course'=>$crs1,
				'banner'=>$bnr_image,
				'image_path'=>config('constants.image_path'),
				'social'=>$social,
			];
			return response($response, 200);
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
			return response($response, 200);
		}
    }

	/**
	 * Function get_subjects
	 * Function to subjects based on course
	 * Method:POST
	 * @params: course_id
	 * return [ subjects ]
	 */
		
	public function get_subjects(Request $request) 
	{
		$cid=$request->course_id;
		$stid=$request->student_id;
			
		$data = Subject::where('course_id',$cid)->orderBy('reorder_no','ASC')->get()->toArray();
		$bnr = DashboardBanner::where('banner_section',2)->get()->first();
		
		$cu_id=Course::where('id',$cid)->first('unique_id');
		$cuid=(!empty($cu_id))?$cu_id->unique_id:'';
		
		$bnr_image=(!empty($bnr))?$bnr->banner_image:'';

		$psubids=Package::select('subject_id')
		->whereIn('id',PurchasedPackage::select('package_id')
		->where('course_unique_id',$cuid)->where('student_id',$stid))->get();

		$sbjids='';
		foreach($psubids as $r)
		{
			$sbjids.=','.$r->subject_id;
		}
		
		$sbjids=substr($sbjids,1);
		$sbj_ids=explode(",",$sbjids);
		$sbjids=array_unique($sbj_ids);
		
	    if(!empty($data)) 
		{
			$x=0;
			foreach ($data as $key=>$r)
			{
				//if($r['subject_type']=="MCQ")
				//{
					$ls_count=Lesson::where('subject_id',$r['id'])->count();   //count total lessons
					$data[$key]['lesson_count']=$ls_count;
				//}
				
				$spkg=Package::where('subject_id',$r['id'])->first();
				
				$data[$key]['package_id']=(!empty($spkg))?$spkg->id:0;
				$data[$key]['package_rate']=(!empty($spkg))?$spkg->rate:0; 
				$data[$key]['rate_6_months']=(!empty($spkg))?$spkg->rate_6_months:0; 
				$data[$key]['rate_3_months']=(!empty($spkg))?$spkg->rate_3_months:0; 
				
				//get package_rate
												
				if (in_array($r['id'], $sbjids))
				  {
				     $data[$key]['suscription_staus']=TRUE;
				  }
				else
				  {
				     $data[$key]['suscription_staus']=FALSE;
				  }
			}
			
			$response = [
				'status'=>TRUE,
				'subject'=>$data,  //$data;
				'banner'=>$bnr_image,
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
	 * Function get_lessons
	 * Function to subjects based on course
	 * Method:POST
	 * @params: course_id
	 * return [ subjects ]
	 */
		
	public function get_lessons(Request $request)  //chapters
	{
		$sid=$request->subject_id;
		
		$data = Lesson::where('subject_id',$sid)->orderBy('order_no','ASC')->get();
		
		$x=0;
		foreach ($data as $r)
		{
			$ls_count=LessonVideo::where('lesson_id',$r->id)->count();
			$data[$x]['video_count']=$ls_count;
			
			$mcq_count=LessonMcqTest::where('lesson_id',$r->id)->count();
			$data[$x]['mcq_count']=$mcq_count;
						
			$liv_count=LessonLiveTest::where('lesson_id',$r->id)->count();
			$data[$x]['live_test_count']=$liv_count;
			$x++;
		}
				
	    if(!$data->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'subject'=>$data,
				//'banner'=>$bnr_image,
				'image_path'=>config('constants.image_path'),
			];
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
			
		}
		
		return response($response, 200);
    }

	/**
	 * Function get_promocode_value
	 * Function to get the promocode value
	 * Method:POST
	 * @params: promocode,course_id
	 * return [ value ]
	 */

   public function get_promocode_value(Request $request) 
	{
		$pcode=strtoupper($request->promocode);
		$cid=$request->course_id;
		$os_type=$request->os_type;  // 1-android, 2-ios
		$user_id=$request->user_id;
		$stud_id=$request->student_id;

		$res=[];
		if($user_id!=0)
		{
			$res = Promocode::where('promocode',$pcode)->where('course_id',$cid)->whereNull('discount_course')->where('user_id',$user_id)->first();
		}
		if(empty($res) OR $res==NULL)
		{
			$res = Promocode::where('promocode',$pcode)->whereNull('user_id')->where('course_id',$cid)->first();
		}
		
		$cres = Course::where('id',$cid)->pluck('unique_id');
		$pro_value=0;

	    if(!empty($res)) 
		{
			if($res->expiry_date>=date('Y-m-d'))
			{
				$per=$res->percentage;

				//specific course already purchased, To apply discount for purchased course
				
				$disid=$res->discount_course;
				$dis_crs_id = Course::where('id',$disid)->pluck('unique_id');
				$dis_crs_status=PurchasedPackage::where('student_id',$stud_id)->where('course_unique_id',$dis_crs_id)->count();
				
				//$dis_crs_status is 1, provide discount other wise 0;
				//-------------------------------------------------------------------------
				
				$pkg=Package::where('course_unique_id',$cres)->where('package_type',1)->first();
				
				if(!empty($pkg))
				{
					if($os_type==1)  //android
					{
						$pro_value=$pkg->rate*($per/100);
					}
					else
					{
						$pro_value=$pkg->ios_rate*($per/100);
					}
				}
				
				$response = [
					'status'=>TRUE,
					'promocode'=>$pcode,
					'discount_course_status'=>$dis_crs_status,
					'promocode_vlaue'=>round($pro_value,2),
				];
			}
			else
			{
				$response = ['status'=>FALSE,  "message" => "Code expired."];
			}
		}
		else {
			$response = ['status'=>FALSE, "message" => "Invalid Promocode."];
			
		}
		
		return response($response, 200);
    }

   /**
	 * Function get_referral_code_value
	 * Function to get the referral code value
	 * Method:POST
	 * @params: referral_code
	 * return [ value ]
     */

public function get_referral_code_value(Request $request) 
	{
		$rcode=strtoupper($request->referral_code);
		
		$res = Staff::where('referral_code',$rcode)->first();
		 
	    if(!empty($res)) 
		{
			$response = [
				'status'=>TRUE,
				'referral_code'=>$rcode,
				'referral_value'=>$res->referral_value,
			];
			return response($response, 200);
		}
		else {
			$response = ['status'=>FALSE, "message" => "Referal code not found."];
			return response($response, 200);
		}
    }







public function get_lesson_items(Request $request)  //old app
{
	$lid=$request->lesson_id;
	$stid=$request->student_id;  
		
		$lv_data = LessonVideo::select('lesson_videos.*','videos.title','videos.video_file','videos.video_icon','videos.premium')
					->leftJoin('videos','lesson_videos.video_unique_id','=','videos.unique_id')
					->where('lesson_videos.lesson_id',$lid)->orderBy('order_no','ASC')->get();
					
		$lmat_data = LessonMaterial::select('lesson_materials.*','materials.material_title','materials.material_icon')
					->leftJoin('materials','lesson_materials.material_unique_id','=','materials.unique_id')
					->where('lesson_materials.lesson_id',$lid)->orderBy('order_no','ASC')->get();
					
		$lmcq_data = LessonMcqTest::select('lesson_mcq_tests.subject_id','lesson_mcq_tests.lesson_id','lesson_mcq_tests.mcq_unique_id','lesson_mcq_tests.order_no','mcq_question_papers.id','mcq_question_papers.question_paper_name','mcq_question_papers.question_paper_type','mcq_question_papers.question_paper_icon','mcq_question_papers.premium','mcq_question_papers.instruction','mcq_question_papers.test_time','mcq_question_papers.test_date','mcq_question_papers.start_time','mcq_question_papers.start_time_text','mcq_question_papers.schedule_date')
					->leftJoin('mcq_question_papers','lesson_mcq_tests.mcq_unique_id','=','mcq_question_papers.unique_id')
					->where('lesson_mcq_tests.lesson_id',$lid)->orderBy('order_no','ASC')->get();
		
		
		if(!empty($lmcq_data))
		{
			$x=0;
			foreach($lmcq_data as $r)
			{
				$attn=McqTestResult::distinct()->where('mcq_question_paper_id',$r->qpaper_id)->count();
				$lmcq_data[$x]['attended_test']=$attn;
				$x++;
			}
		}
		
		$llt_data = LessonLiveTest::select('lesson_live_tests.*','mcq_question_papers.id as question_paper_id','mcq_question_papers.question_paper_name','mcq_question_papers.question_paper_type','mcq_question_papers.question_paper_icon','mcq_question_papers.premium','mcq_question_papers.instruction','mcq_question_papers.test_time','mcq_question_papers.test_date','mcq_question_papers.start_time','mcq_question_papers.start_time_text','mcq_question_papers.schedule_date')
					->leftJoin('mcq_question_papers','lesson_live_tests.live_unique_id','=','mcq_question_papers.unique_id')
					->where('lesson_live_tests.lesson_id',$lid)->orderBy('order_no','ASC')->get();
				
			/*$data['videos']=$lv_data;
			$data['Material']=$lmat_data;
			$data['mcq_test']=$lmcq_data;
			$data['live_test']=$llt_data;*/
			
			foreach($llt_data as $key=>$r)
			{
				//-----test already attended check-----//
				$attn=McqTestResult::distinct()->where('mcq_question_paper_id',$r->question_paper_id)->count();
				$llt_data[$key]['attended_test']=$attn;
				
				$atts=McqTestResult::distinct()->where('student_id',$stid)->where('mcq_question_paper_id',$r->question_paper_id)->count();
				if($atts>0){$att_status=true;}else{$att_status=false;}
				
				$llt_data[$key]['attended_status']=$att_status;
				//-------------------------
				
				$llt_data[$key]['id']=$r->question_paper_id;
			}
			
	    	$response = [
				'status'=>TRUE,
				'videos'=>$lv_data,
				'material'=>$lmat_data,
				'mcq_test'=>$lmcq_data,
				'live_test'=>$llt_data,
				
				//'banner'=>$bnr_image,
				'image_path'=>config('constants.image_path'),
				'file_path'=>config('constants.file_path'),
			];
		
		return response($response, 200);
}


public function get_lesson_items_new(Request $request)  //for updated app 
{
	$lid=$request->lesson_id;
	$stid=$request->student_id;
	$vsearch =$request->search_video;
	
	$lv_data1 = LessonVideo::select('lesson_videos.*','videos.title','videos.video_file','videos.video_icon','videos.premium')
				->leftJoin('videos','lesson_videos.video_unique_id','=','videos.unique_id');
	if($vsearch!=""){
		$lv_data1->where('lesson_videos.lesson_id',$lid)->where('videos.title','like','%'.$vsearch.'%');
	}
	else{
		$lv_data1->where('lesson_videos.lesson_id',$lid);
	}		
	
	$lv_data=$lv_data1->orderBy('order_no','ASC')->get();
	
	
		/*$lv_data = LessonVideo::select('lesson_videos.*','videos.title','videos.video_file','videos.video_icon','videos.premium')
					->leftJoin('videos','lesson_videos.video_unique_id','=','videos.unique_id')
					->where('lesson_videos.lesson_id',$lid)->orderBy('order_no','ASC')->get();*/
	
		$lmat_data = LessonMaterial::select('lesson_materials.*','materials.material_title','materials.material_icon')
					->leftJoin('materials','lesson_materials.material_unique_id','=','materials.unique_id')
					->where('lesson_materials.lesson_id',$lid)->orderBy('order_no','ASC')->get();
					
		$lmcq_data = LessonMcqTest::select('lesson_mcq_tests.subject_id','lesson_mcq_tests.lesson_id','lesson_mcq_tests.mcq_unique_id','lesson_mcq_tests.order_no','mcq_question_papers.id','mcq_question_papers.question_paper_name','mcq_question_papers.question_paper_icon','mcq_question_papers.premium','mcq_question_papers.instruction','mcq_question_papers.test_time','mcq_question_papers.test_date','mcq_question_papers.start_time','mcq_question_papers.start_time_text','mcq_question_papers.schedule_date')
					->leftJoin('mcq_question_papers','lesson_mcq_tests.mcq_unique_id','=','mcq_question_papers.unique_id')
					->where('lesson_mcq_tests.lesson_id',$lid)->orderBy('order_no','ASC')->get();
		
		//------number of person attend this test -----------
		if(!empty($lmcq_data))
		{
			foreach($lmcq_data as $key=>$r)
			{
				$attn=McqTestResult::distinct()->where('mcq_question_paper_id',$r->qpaper_id)->count();
				$lmcq_data[$key]['attended_test']=$attn;
			}
		}
		
		$llt_data = LessonLiveTest::select('lesson_live_tests.*','mcq_question_papers.id as question_paper_id','mcq_question_papers.question_paper_name','mcq_question_papers.question_paper_icon','mcq_question_papers.premium','mcq_question_papers.instruction','mcq_question_papers.test_time','mcq_question_papers.test_date','mcq_question_papers.start_time','mcq_question_papers.start_time_text','mcq_question_papers.schedule_date')
					->leftJoin('mcq_question_papers','lesson_live_tests.live_unique_id','=','mcq_question_papers.unique_id')
					->where('lesson_live_tests.lesson_id',$lid)->orderBy('order_no','ASC')->get();
				
			if(!empty($llt_data))
			{
				foreach($llt_data as $key=>$r)
				{
					$attno=McqTestResult::distinct()->where('mcq_question_paper_id',$r->question_paper_id)->count();
					$llt_data[$key]['attended_test']=$attno;
					
					$atts=McqTestResult::distinct()->where('student_id',$stid)->where('mcq_question_paper_id',$r->question_paper_id)->count();
                    if($atts>0){$att_status=true;}else{$att_status=false;}
                    $llt_data[$key]['attended_status']=$att_status;


					$llt_data[$key]['id']=$r->question_paper_id;
				}
			}
			
	    	$response = [
				'status'=>TRUE,
				'videos'=>$lv_data,
				'material'=>$lmat_data,
				'mcq_test'=>$lmcq_data,
				'live_test'=>$llt_data,
				
				//'banner'=>$bnr_image,
				'image_path'=>config('constants.image_path'),
				'file_path'=>config('constants.file_path'),
			];
		
		return response($response, 200);
}

public function get_lesson_item_details(Request $request)
{
	$stid=$request->student_id;
	$iuid=$request->item_unique_id;
	$tab_id=$request->tab_id;  	//1-video,2-material,3-mcq, 4 live-test
	$data=[];
	
	if($tab_id==1)  //videos
	{
	   $data = Video::where('unique_id',$iuid)->orderBy('id','ASC')->get();
	   
	   $x=0;
	   foreach($data as $r)
	   {
			$where1=['material_type'=>1,'video_unique_id'=>$r->unique_id,'like'=>1];
			$lk_cnt=MaterialLike::where($where1)->count();
			$data[$x]['like_count']=($lk_cnt)?$lk_cnt:0;
			
			//-------------------like-dislike status
			$where1=['student_id'=>$stid,'video_unique_id'=>$r->unique_id];
			$lik=MaterialLike::where($where1)->first();
			
			$lik_status=False;
			$dlik_status=False;
			
			if(!empty($lik))
			{
				if($lik->like==1){ $lik_status=True;$dis_like=false;} else { $lik_status=False;	$dlik_status=True;}
			}
			$data[$x]['like_status']=$lik_status;
			$data[$x]['dislike_status']=$dlik_status;
			//--------------------
	   }
	   
	}
	else if($tab_id==2)  //materials
	{
	   $data = Material::where('unique_id',$iuid)->orderBy('id','ASC')->get();
	}
	else if($tab_id==3)   //mcq questions
	{
		$data = McqQuestion::whereIn('mcq_question_paper_id',
		McqQuestionPaper::select('id')->where('unique_id',$iuid)->where('question_paper_type',1))->orderBy('id','ASC')->get();
	}
	else if($tab_id==4)   //live test questions
	{
		$data = McqQuestion::whereIn('mcq_question_paper_id',
		McqQuestionPaper::select('id')->where('unique_id',$iuid)->where('question_paper_type',2))->orderBy('id','ASC')->get();
	}
	
	if(!empty($data))
	{	
	    $response = [
			'status'=>TRUE,
			'data'=>$data,
			'image_path'=>config('constants.image_path'),
		];
	}
	else
	{
		$response = ['status'=>FALSE,'data'=>$data, "message" => "No data were found."];
	}
		
	return response($response, 200);
}


/**
	 * Function get_latest_news
	 * Function to get the latest news details
	 * Method:POST
	 * @params: student_id
	 * return [ details ]
	 */

public function get_latest_news(Request $request)  
{
	$stid=$request->student_id;

		$nws1=LatestNews::select('latest_news.*',)
		->where('status',1)->where('news_type',2)->orderBy('display_order','ASC')->get()->toArray();
		
		$nws2=LatestNews::select('latest_news.*')
		->where('status',1)->where('news_type',1)->whereDate('class_date','>=',date('Y-m-d'))
		->orderBy('display_order','ASC')->get()->toArray();
		
		
		$data=[];
		$data=array_merge($data,$nws2,$nws1);
						
		$response = [
			'status'=>TRUE,
			'comment'=>'news_type, 1-Live class,2-Others',
			'data'=>$data,
		];
		
	return response($response, 200);	
}


/**
	 * Function get_subject_live_classes
	 * Function to get the subject live clasess details
	 * Method:POST
	 * @params: student_id
	 * return [ details ]
	 */


public function get_subject_live_class(Request $request)  //live class for dashboard
{
	   $subid=$request->subject_id;

		$lvclas=SubjectLiveClass::select('subject_live_class.*',)
			->where('class_date',date('Y-m-d'))->where('status',1)->orderBy('display_order','ASC')->get();
		
		if(!$lvclas->isEmpty())
		{
		$response = [
			'status'=>TRUE,
			'data'=>$lvclas,
		];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			'comment'=>"no live class were found.",
			];
		}
		
	return response($response, 200);	
}


	/**
	 * Function set_video_like_dislike
	 * Function to get the like and dislike of the videos
	 * Method:POST
	 * @params: student_id,material_unique_id, like, dislike
	 * return [ details ]
	 * if like video set like=1, dislike=0
	 * if dislike video set dislike=1 , like=0
	 */

public function set_video_like_dislike(Request $request) 
	{
		$stid=$request->student_id;
		$vuid=$request->video_unique_id;
		$like=$request->like;
		$dlike=$request->dislike;
		
		$where1=['material_type'=>1,'student_id'=>$stid,'video_unique_id'=>$vuid];
		$res=MaterialLike::where($where1)->delete(); //delete old like and dislike
				
		$result=MaterialLike::create([
			'student_id'=>$stid,
			'video_unique_id'=>$vuid,
			'material_type'=>1,
			'like'=>$like,
			'dislike'=>$dlike,
		]);
		
		if($result) 
		{
			$response = [
				'status'=>TRUE,
				'message'=>'Details added.'];
		}
		else {
			
			$response = [
				'status'=>FALSE,
				"message" => "something wrong, try again."];
			
		}
		return response($response, 200);
    }

	/**
	 * Function set_video_feedbacks
	 * Function to set video comments
	 * Method:POST
	 * @params: student_id,material_unique_id, comment
	 * return [ details ]
	 */

public function set_video_feedbacks(Request $request) 
	{
		$stid=$request->student_id;
		$vuid=$request->video_unique_id;
		$cmnt=$request->comment;
			
		$where1=['material_type'=>1,'student_id'=>$stid,'video_unique_id'=>$vuid];
		$res=MaterialComment::where($where1)->delete(); //delete old comment
		
		$result=MaterialComment::create([
			'student_id'=>$stid,
			'video_unique_id'=>$vuid,
			'material_type'=>1,
			'comments'=>$cmnt,
		   ]);
		
		if($result)
		{
			$response = [
			'status'=>TRUE,
			"message" => "Feedback added."];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			"message" => "Something wrong, try again."];
		}
		return response($response, 200);
    }

	/**
	 * Function set_general_feedbacks
	 * Function to set general feedbacks
	 * Method:POST
	 * @params: name,mobile,comment
	 * return [ details ]
	 */

public function set_general_feedbacks(Request $request) 
{
	$nam=$request->name;
	$mob=$request->mobile;
	$cmnt=$request->comment;

	
	$result=GeneralFeedback::create([
		'name'=>$nam,
		'mobile'=>$mob,
		'feedbacks'=>$cmnt,
	   ]);
	
	if($result)
	{
		$response = [
		'status'=>TRUE,
		"message" => "Feedback added."];
	}
	else
	{
		$response = [
		'status'=>FALSE,
		"message" => "Something wrong, try again."];
	}
	return response($response, 200);
}

/**
	 * Function set_general_feedbacks
	 * Function to set general feedbacks
	 * Method:POST
	 * @params: name,mobile,comment
	 * return [ details ]
	 */


public function get_notifications(Request $request) 
	{
		$stid=$request->student_id;
		
		$dats=Package::select('course_unique_id','subject_id')->whereIn('id',PurchasedPackage::select('package_id')
		->where('student_id',$stid))->get();
		
		$subids=[];
		$cuids=[];
		$data=[];
		
		if(!empty($dats))
		{
			foreach($dats as $r)
			{
				$subids[]=$r->subject_id;
				$cuids[]=$r->course_unique_id;
			}
		}

		$nt1=Notification::where('message_type',1)->get()->toArray();  //general
		$nt2=Notification::whereIn('course_unique_id',$cuids)->where('message_type',3)->get()->toArray();  //course
		
		$data=array_merge($data,$nt1,$nt2);

		if(!empty($subids))
		{
			foreach($subids as $r)
			{
				$nt3=Notification::where('subject_id',$r)->get()->toArray();  //subject
				$data=array_merge($data,$nt3);
			}
		}
		
		usort($data, fn($a, $b) => $a['id'] <=> $b['id']);
				
		if(count($data)>0)
		{
		  $response = [
			'status'=>TRUE,
			'data'=>$data,
			"message" => "Notifications."];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			"message" => "No data were found."];
		}
		
		return response($response, 200);
	}


   /**
	 * Function add_chat message
	 * Function to add chat message
	 * Method:POST
	 * @params: student_id,message
	 * return [ true/false ]
    */
	

  public function add_chat_messages(Request $request) 
	{
		$stid=$request->student_id;
		$mess=$request->message;
		$img=$request->image;
		
		$fname="";
		
		if($request->file('image'))
		{
			$ext=$request->file('image')->getClientOriginalExtension();	 
			$filename = "img_".date('Ymdhis').".".$ext;
			$fname ="mediguru/chat_images/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/chat_images",$request->file('image'), $filename, 'public');
		}
		
		$result=ChatData::create([
			'student_id'=>$request->student_id,
			'admin_id'=>null,
			'message'=>$request->message,
			'pictures'=>$fname,
			'user_type'=>1,
			'status'=>1
		   ]);
		
		if($result)
		{
			$response = [
			'status'=>TRUE,
			"message" => "Chat message added."];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			"message" => "No message were found."];
		}
		
		return response($response, 200);
    }


    /**
	 * Function get_chat messages
	 * Function to get chat messages
	 * Method:POST
	 * @params: student_id
	 * return [ true/false ]
	*/

  public function get_chat_messages(Request $request) 
	{
		$stid=$request->student_id;
				
		$pc=PurchasedPackage::select('course_unique_id')->where('student_id',$stid)->get();
		
		$cuid=[];
		if(!empty($pc))
		{
			foreach($pc as $r)
			{
			  $cuid[]=$r->course_unique_id;
			}
		}
		
		$cdts=ChatData::select('chat_datas.*')
		->leftJoin('students','chat_datas.student_id','=','students.id')
		->Where('chat_datas.student_id',$stid)->orWhereIn('chat_datas.course_unique_id',$cuid)->orderBy('chat_datas.id','ASC')->get()->toArray();
		if($cdts)
		{
			$new=['status'=>0];
			foreach($cdts as $r)
			{
				$res=ChatData::where('id',$r['id'])->update($new);  //clear chat status
			}
			
			$response = [
			'status'=>TRUE,
			'data'=>$cdts,
			'image_path'=>config('constants.image_path')
			];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			"message" => "No message were found."];
			
		}
		
		return response($response, 200);
		//created_at changed to indian time format in app (adding 5:30 hours)
    }

public function remove_chat(Request $request) 
	{
		$cid=$request->chat_id;
		
		$cdt= ChatData::where('id',$cid)->first();
 
		if(!empty($cdt))
		{
		   $fna1="uploads/".$cdt->pictures;
		   if(file_exists($fna1))
		   {
		     $fn1="uploads/$cdt->pictures";
			 File::delete($fn1);
		   }
		   
		  $res=$cdt->delete();
		  
		  $response = [
			'status'=>TRUE,
			'message'=>"Chat successfully removed."
			];
		  
		}
		else 
		{
			$response = [
			'status'=>FALSE,
			"message" => "Something wrong, try again."
			];
		}
		
		return response($response, 200);
	}


public function get_new_chat_count(Request $request) 
	{
		$sid=$request->student_id;
		
		$cnt= ChatData::where('student_id',$sid)->where('status',1)->count();
		
		if($cnt>0)
		{
		 $response = [
			'status'=>TRUE,
			'chat_count'=>$cnt,
			'message'=>"New message were found."
			];
		}
		else
		{
		    $response = [
			'status'=>FALSE,
			'chat_count'=>$cnt,
			'message'=>"No new message were found."
			];	
		}
		
		return response($response, 200);
	}

// to display course schedule details
// parms: course_unique_id
//method :post

public function get_course_schedule(Request $request) 
	{
		$cuid=$request->course_unique_id;
		
		$dat= CourseSchedule::where('course_unique_id',$cuid)->first();
		
		if(!empty($dat))
		{
			
		 $response = [
			'status'=>TRUE,
			'course_schedule'=>$dat,
			];
		}
		else
		{
		    $response = [
			'status'=>FALSE,
			'message'=>"No data were found."
			];	
		}
		
		return response($response, 200);
	}
	
	
   // FORCHAT APP API - -----------------------------------------------
   
		
	public function add_admin_chat_message(Request $request)
	{
		$stud_id=$request->student_id;
		$admin_id=$request->admin_id;
		$message=$request->message;
		$image_status=$request->image_status;
		
		//image_status :  1-image, 0-text message
		$result="";
		
		if($image_status==0)
		{
		
			$pc=PurchasedPackage::where('student_id',$request->stud_id)->first();
			$cuid=null;
			if(!empty($pc))
			{
				$cuid=$pc->course_unique_id;
			}
			
			$result=ChatData::create([
				'course_unique_id'=>$cuid,
				'student_id'=>$stud_id,
				'admin_id'=>$admin_id,
				'message'=>$message,
				'user_type'=>2,
				'status'=>1
				]);
		}
		else   //add image
		{

			$fname='';
			if($request->file('image_file'))
			{
				$ext=$request->file('image_file')->getClientOriginalExtension();	 
				$filename = "img_".date('Ymdhis').".".$ext;
				$fname ="mediguru/chat_images/".$filename;
				Storage::disk('spaces')->putFileAs("mediguru/chat_images",$request->file('image_file'), $filename, 'public');
		
			}

			$result=ChatData::create([
			'student_id'=>$request->student_id,
			'admin_id'=>$request->admin_id,
			'message'=>Null,
			'pictures'=>$fname,
			'user_type'=>2,
			'status'=>1
			]);
		}
		
		if($result)
		{
			$response = [
			'status'=>TRUE,
			"message" => "Chat message added."];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			"message" => "something wrong, Try again."];
		}
		
		return response($response, 200);
	}	
		
	
	public function admin_remove_chat(Request $request) 
	{
		$cid=$request->chat_id;
		
		$cdt= ChatData::where('id',$cid)->first();
 
		if(!empty($cdt))
		{
		   $fna1="uploads/".$cdt->pictures;
		   if(file_exists($fna1))
		   {
		     $fn1="uploads/$cdt->pictures";
			 File::delete($fn1);
		   }
		   
		  $res=$cdt->delete();
		  
		  $response = [
			'status'=>TRUE,
			'message'=>"Chat successfully removed."
			];
		  
		}
		else 
		{
			$response = [
			'status'=>FALSE,
			"message" => "Something wrong, try again."
			];
		}
		
		return response($response, 200);
	}

//get student chat messages -----------------------------------


	public function admin_get_chat_messages(Request $request) 
	{
		$stid=$request->student_id;
				
		$pc=PurchasedPackage::select('course_unique_id')->where('student_id',$stid)->get();
		
		$cuid=[];
		if(!empty($pc))
		{
			foreach($pc as $r)
			{
			  $cuid[]=$r->course_unique_id;
			}
		}
		
		$cdts=ChatData::select('chat_datas.*')
		->leftJoin('students','chat_datas.student_id','=','students.id')
		->Where('chat_datas.student_id',$stid)->orWhereIn('chat_datas.course_unique_id',$cuid)->orderBy('chat_datas.id','ASC')->get()->toArray();
		if($cdts)
		{
			$new=['status'=>0];
			foreach($cdts as $r)
			{
				$res=ChatData::where('id',$r['id'])->update($new);  //clear chat status
			}
			
			$response = [
			'status'=>TRUE,
			'data'=>$cdts,
			'image_path'=>config('constants.image_path')
			];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			"message" => "No message were found."];
			
		}
		
		return response($response, 200);
		//created_at changed to indian time format in app (adding 5:30 hours)
    }



//--- get chat student list -------------------------------
	
	
	public function admin_chat_students(Request $request) 
	{

		$studs=ChatData::select('students.id','students.name','students.student_image','chat_datas.status as new_status')
			->join('students',"chat_datas.student_id","=","students.id")
			->groupBy('students.id','students.name','chat_datas.status')
			->orderBy('chat_datas.status','DESC')->get();
		
		$data=[];
		$dat=[];
		if(!$studs->isEmpty())
		{
			foreach($studs as $r)
			{
				$cnt=ChatData::where('student_id',$r->id)->where('status',1)->count();
				$cdt=ChatData::where('student_id',$r->id)->orderBy('id','DESC')->first();
								
				$dat['id']=$r->id;
				$dat['name']=$r->name;
				$dat['new_chat_count']=$cnt;
				$dat['create_date']=$cdt->created_at??"";
				$dat['last_message']=$cdt->message??"";
				$dat['sender_id']=($cdt->admin_id!="")?$cdt->admin_id:$cdt->student_id;
				$dat['student_image']=$r->student_image??"";
				$data[]=$dat;
			}

			$response = [
			'status'=>TRUE,
			'data'=>$data,
			'image_path'=>config('constants.image_path')
			];
		}
		else
		{
			$response = [
			'status'=>FALSE,
			"message" => "No students were found."];
			
		}

		return response($response, 200);
	}

}
