<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\{Course,Subject,Package,SharedSubject}; 
use App\Models\{Lesson,LessonVideo,LessonMcqTest,LessonLiveTest,LessonMaterial,LessonVideoQuestion}; 

use Validator;
use Session;
use DataTables;
use DB;

class SubjectController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
    
	$crs = (new Course())->getCourses(); 
	$sub = (new Subject())->getSubjects(); 
	return view('admin.subject.subject_new',compact('crs','sub'));  //add subject and package
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Subject::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   //$result=(new Subject())->addSubject($request);
		   
		   $result=(new Subject())->add_Subject($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Subject successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('subjects');
	}
	
	
	public function edit($id)
	{
		$sub=(new Subject())->getSubjectById($id);
		$crs=(new Course())->getCourses();
		return view('admin.subject.edit_subject',compact('crs','sub'));
	}
	
	
	public function update_subject(Request $request)
	{

		$validate=Validator::make($request->all(),Subject::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Subject())->updateSubject($request);

			if($result)
			{
				Session::flash('message', 'success#Subject successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('subjects');
	}
  
  
   public function destroy($id)
	{

		$result=(new Subject())->deleteSubject($id);
		
			if($result)
			{
				$res=Package::where('subject_id',$id)->delete();
				Session::flash('message', 'success#Subject successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('subjects');
	}

	
	 public function viewSubjects($request)
	{
		
		$search=$request->search;
		
		
		$dts=Subject::select('subjects.*','courses.course_name')
		->leftJoin('courses','subjects.course_id','courses.id')
		->where(function($where) use($search)
			    {
					$where->where('subjects.subject_name', 'like', '%' .$search . '%')
					->orWhere('subjects.subscription_end_date', 'like', '%' .$search . '%')
					->orWhere('subjects.subject_type', 'like', '%' .$search . '%')
					->orWhere('subjects.course_unique_id', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%');
			  })->orderBy('subjects.id','ASC')->get();
		
		$data = array();
		$udata = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {

				$udata['id'] =$r->id;
				$udata['cimg']='<img src="'.config('constants.file_path').$r->subject_icon.'" style="width:50px;height:50px">';
				$udata['cname']=$r->course_name;
				$udata['sname']=$r->subject_name;
				
				if($r->subscription_end_date!=""){
				$udata['sname'].='<br><span title="Subscription end date" style="color:#f54138;">Expiry:'.date_create($r->subscription_end_date)->format('d-m-Y').'</span>';
				}
				$udata['sname'].='<br><span title="App store product id" style="color:#2b489b;">App ID: '.$r->app_store_product_id.'</span>';
				
				if($r->ios_subscription_type==1){ $ios_type="Subscription";}
				else if($r->ios_subscription_type==2){ $ios_type="Consumable";}
				else { $ios_type="";}
								
				$udata['sname'].='<br><span title="Subscriptin Type" style="color:#2b489b;">Type: '.$ios_type.'</span>';

				$udata['stype']=$r->subject_type;
				$udata['desc']=$r->description;
				$udata['mark']='Mark:'.$r->question_mark.'<br> Neg:'.$r->negative_mark;
								
				if($r->status==1){
					$st='<span class="badge badge-success">Active</span>';
				}
				else{
					$st='<span class="badge badge-danger">Inactive</span>';
				}
				
				$udata['status']=$st;
								
				$btn='<a href="" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="'.url('delete_subject').'/'.$r->id.'" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>';
									
				if($r->status==1){
					$btn.='&nbsp;<a href="'.url('deactivate_subject').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				}
				else{
					$btn.='&nbsp;<a href="'.url('activate_subject').'/'.$r->id.'" class="btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				}
				
				$btn.='&nbsp;<a href="" id="'.$r->id.'" class="btnCopySubject btn btn-info btn-elevate btn-circle btn-icon" data-toggle="modal" title="Copy Subject"><i class="fa fa-clone"></i></a>';
				
				$udata['action']=$btn;
				
				$data[] = $udata;
			}
        }

		return $data;
	}
	
	public function view_data(Request $request)
	{
		if ($request->ajax()) {
            $data = $this->viewSubjects($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['cimg','action','desc','mark','status','sname'])
                    ->make(true);
        }
	}
		
	
	public function get_subjects_by_course_id($id)
	{
		$subs=(new Subject())->getSubjectsByCourseId($id);
		
		$opt="<option value=''>--select--</option>";
		if(!$subs->isEmpty())
		{
			foreach($subs as $r)
			{
			$opt.="<option value='".$r->id."'>".$r->subject_name."</option>";
			}
			
		}
		return $opt;
	}
	
	public function get_subjects_by_course_unique_id($id)
	{
		$subs=(new Subject())->getSubjectsByCourseUniqueId($id);
		
		$opt="<option value=''>--select--</option>";
		if(!$subs->isEmpty())
		{
			foreach($subs as $r)
			{
			$opt.="<option value='".$r->id."'>".$r->subject_name."</option>";
			}
			
		}
		return $opt;
	}

	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Subject::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Subject successfully activated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('subjects');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Subject::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Subject successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('subjects');
	}
	

//----------------------------RE-ORDER SUBJECTS---------------------------------------------------

public function reorder_subjects()
{
	$crs = (new Course())->getCourses(); 
	return view('admin.subject.reorder_subject',compact('crs'));
}

	
public function get_subjects_for_reorder($cuid) 
{
	$subs=(new Subject())->getSubjectsForReorder($cuid);
	
	$opt='';
	if(!$subs->isEmpty())
	{
		foreach($subs as $key=>$r)
		{
		$opt.='<li class="ui-state-default" data-id="'.$r->id.'">'.++$key." - ".strtoupper($r->subject_name).'</li>';
		}
	}
	return $opt;
}

//------------------------subject re-ordering----------------------------------
	
	
	public function set_subjects_reorder(Request $request)
	{
		$sids=$request->subids;
		$suids=explode(',',$sids);
		
		$result='';
		
		if(count($suids)>0)
		{
			foreach($suids as $key=>$r)
			{
				$new=['reorder_no'=>++$key];
				$result=Subject::where('id',$r)->update($new);
			}
		}

		return $result;
	}


/*public function get_subject_detail_for_share($id)
{
	$sub=(new Subject())->getSubjectById($id);
	$crs=(new Course())->getCourses();
	return view('admin.subject.share_subject',compact('crs','sub'));
}*/

public function get_subject_detail_for_copy($id)
{
	$sub=(new Subject())->getSubjectById($id);
	
	$lessons=Lesson::where('subject_id',$id)->get();
	$no_of_lessons=$lessons->count();
	
	$ltest=$mtest=$vids=$pdfs=0;
	$les_ids="";
	
	foreach($lessons as $r)
	{
		$ltest+=LessonLiveTest::where('subject_id',$id)->where('lesson_id',$r->id)->count();
		$mtest+=LessonMcqTest::where('subject_id',$id)->where('lesson_id',$r->id)->count();
		$vids+=LessonVideo::where('subject_id',$id)->where('lesson_id',$r->id)->count();
		$pdfs+=LessonMaterial::where('subject_id',$id)->where('lesson_id',$r->id)->count();
		$les_ids.=",".$r->id;
	}	
	
	$details['no_of_lessons']=$no_of_lessons;
	$details['no_of_live_test']=$ltest;
	$details['no_of_mcq_test']=$mtest;
	$details['no_of_videos']=$vids;
	$details['no_of_pdfs']=$pdfs;
	$details['lesson_ids']=substr($les_ids,1);
		
	return response()->json(['subjects'=>$sub,'details'=>$details,'msg'=>'Subject details.', 'status'=>'error']);
	//return view('admin.subject.share_subject',compact('crs','sub'));
}


/*public function share_subject(Request $request)
{
	
	$crs_id=$request->share_course_id;
	$sub_id=$request->share_subject_id;
	
	
	$cnt=SharedSubject::where('course_id',$crs_id)->where('subject_id',$sub_id)->count();
	if($cnt>0)
	{
		$response=response()->json(['msg'=>'Subject already shared in this course.', 'status'=>'error']);
	}
	else
	{
		$res=SharedSubject::create([
			'course_id'=>$crs_id,
			'subject_id'=>$sub_id,
		]);

		$response= response()->json(['msg'=>'Subject successfully shared.', 'status'=>'success']);
	}
	
	return $response;

}*/


public function copy_subject_to_course()
{
	
	$sub_id=request('sel_subject_id');
	$sub_name=request('sel_subject_name');
	$new_subject_name=request('new_subject_name');
	$crs_id=request('copy_course_id');
	$lesson_ids=explode(',',request('lesson_ids'));
	
	$less=Lesson::whereIn('id',$lesson_ids)->get();
	
	$fname="";
		
		/*if($request->file('subject_icon'))
		{
			$ext=$request->file('subject_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/subject_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/subject_icons",$request->file('subject_icon'), $filename, 'public');
		}*/
		
	$cuid=Course::where('id',$crs_id)->first();
	$subDet=Subject::where('id',$sub_id)->first();
								
	$result=Subject::create([
		'course_id'=>$cuid->id,
		'course_unique_id'=>$cuid->unique_id,
		'subject_name'=>$new_subject_name,
		'subject_type'=>$subDet->subject_type??null,
		'description'=>$subDet->description,
		'question_mark'=>$subDet->question_mark,
		'negative_mark'=>$subDet->negative_mark,
		'subscription_end_date'=>$subDet->subscription_end_date,
		'app_store_product_id'=>null,
		'subject_icon'=>$fname,
		'ios_subscription_type'=>$subDet->subscription_type,
		'status'=>1
	]);
		
	$nsub_id=$result->id;
		
	DB::beginTransaction();
	
	foreach($less as $key=>$ls)
	{
			
		try
		{

			$new=['subject_id'=>$nsub_id,
				  'lesson_name'=>$ls->lesson_name,
				  'lesson_icon'=>$ls->lesson_icon,
				  'order_no'=>$ls->order_no,
				  'status'=>1
				  ];
				  
			$les_res=Lesson::create($new);
			$new_lid=$les_res->id;
			$lsid=$ls->id;
			
			$lv_dat=LessonVideo::select('subject_id','lesson_id','video_unique_id','order_no')
				->where('lesson_id',$lsid)->where('subject_id',$sub_id)->get()->map(function($q) use($nsub_id,$new_lid)
				{
					$q['subject_id']=$nsub_id;
					$q['lesson_id']=$new_lid;
					return $q;
				})->toArray();
			
				DB::table('lesson_videos')->insert($lv_dat);

			//-----------------------------------------------------------------------
			
				$lm=LessonMaterial::select('subject_id','lesson_id','material_unique_id','order_no')
				->where('lesson_id',$lsid)->where('subject_id',$sub_id)->get()->map(function($q) use($nsub_id,$new_lid)
				{
					$q['subject_id']=$nsub_id;
					$q['lesson_id']=$new_lid;
					return $q;
				})->toArray();
				
				DB::table('lesson_materials')->insert($lm);

			//-----------------------------------------------------------------------
			
				$lmt=LessonMcqTest::select('subject_id','lesson_id','mcq_unique_id','order_no')
				->where('lesson_id',$lsid)->where('subject_id',$sub_id)->get()->map(function($q) use($nsub_id,$new_lid)
				{
					$q['subject_id']=$nsub_id;
					$q['lesson_id']=$new_lid;
					return $q;
				})->toArray();
				
				DB::table('lesson_mcq_tests')->insert($lmt);
				
			//-----------------------------------------------------------
				
				$llt=LessonLiveTest::select('subject_id','lesson_id','live_unique_id','order_no')
				->where('lesson_id',$lsid)->where('subject_id',$sub_id)->get()->map(function($q) use($nsub_id,$new_lid)
				{
					$q['subject_id']=$nsub_id;
					$q['lesson_id']=$new_lid;
					return $q;
				})->toArray();
				
				DB::table('lesson_live_tests')->insert($llt);

			DB::commit();
			$response=true;
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			DB::rollback();
			$response=false;
		}

	}

	return $response;
}


}
