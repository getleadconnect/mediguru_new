<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;

use \Carbon\carbon;

class LiveQuestionPaper extends Model
{
    use HasFactory;
	
	protected $table='mcq_question_papers';
	
    protected $fillable = [
      'course_id','unique_id','question_paper_type','question_paper_name','premium','instruction',
	  'test_time','test_date','start_time','start_time_text','schedule_date','question_paper_icon','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'unique_id'=>'required',
	'premium'=>'required',
	'question_paper_name'=>'required',
	'question_paper_icon'=>'required',
	'test_time'=>'required',
	'question_mark'=>'required',
	'negative_mark'=>'required',
	];
	
	public const EDIT_RULES=[
	'course_id'=>'required',
	'unique_id'=>'required',
	'premium'=>'required',
	'question_paper_name'=>'required',
	'test_time'=>'required',
	'instruction'=>'required',
	'question_mark'=>'required',
	'negative_mark'=>'required',
	];
			
	public function addQuestionPaper($request)
	{
		
		$fname="";
		if($request->file('question_paper_icon'))
		{
			$ext=$request->file('question_paper_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/qpaper_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/qpaper_icons",$request->file('question_paper_icon'), $filename, 'public');

		}
		
		$tdate=$request->test_date??null;
		
		$stime=null;$sttime=null;
		if($request->start_time!=null)
		{
			$stime=$request->start_time;
			$sttime=\Carbon\Carbon::createFromFormat('H:i', $stime)->format('h:i A');
		}

		return self::create([
			'course_id'=>$request->course_id,
			'unique_id'=>$request->unique_id,
			'question_paper_name'=>$request->question_paper_name,
			'question_paper_type'=>2,
			'premium'=>$request->premium,
			'instruction'=>$request->instruction,
			'question_paper_icon'=>$fname,
			'test_time'=>$request->test_time,
			'schedule_date'=>null,
			'test_date'=>$tdate,
			'start_time'=>$stime,
			'start_time_text'=>$sttime,
			'question_mark'=>$request->question_mark,
			'negative_mark'=>$request->negative_mark,
			'status'=>1
			
		]);
		
	}
	
	public function updateQuestionPaper($request)
	{
		
		$fname=$request->qpaper_icon;
		
		$id=$request->qpaper_id;
			
		if($request->file('question_paper_icon'))
		{
			
			$dat=self::find($id);
			$fna=$dat->question_paper_icon;

			$ext=$request->file('question_paper_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/qpaper_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/qpaper_icons",$request->file('question_paper_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$tdate=$request->test_date??null;
		
		$stime=null;$sttime=null;
		
		if($request->start_time!=null)
		{
			$stime=$request->start_time;
			$sttime = Carbon::parse($stime)->format('h:i A');
		}
					
		
		$dat=[
			'course_id'=>$request->course_id,
			'unique_id'=>$request->unique_id,
			'question_paper_name'=>$request->question_paper_name,
			'question_paper_type'=>2,
			'premium'=>$request->premium,
			'instruction'=>$request->instruction,
			'question_paper_icon'=>$fname,
			'test_time'=>$request->test_time,
			'schedule_date'=>null,
			'test_date'=>$tdate,
			'start_time'=>$stime,
			'start_time_text'=>$sttime,
			'question_mark'=>$request->question_mark,
			'negative_mark'=>$request->negative_mark,
			'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getQuestionPaperById($id)
	{
		$data=self::select('mcq_question_papers.*')->where('mcq_question_papers.id',$id)->first();
		
		return $data;
	}
	
 public function viewQuestionPapers($request,$qptype)  //view data
	{
		$search=$request->search;
	
		$dts=self::select('mcq_question_papers.*','courses.course_name')
		->leftJoin('courses','mcq_question_papers.course_id','=','courses.id')
		->where('question_paper_type',$qptype)
		->where(function($where) use($search)
			    {
					$where->where('mcq_question_papers.question_paper_name', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('mcq_question_papers.unique_id', 'like', '%' .$search . '%')
					->orWhere('mcq_question_papers.test_time', 'like', '%' .$search . '%');
			  })->orderBy('mcq_question_papers.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {

					$q_count=McqQuestion::where('mcq_question_paper_id',$r->id)->count();
					
					if($r->status==1)
						$st='<span class=" kt-badge kt-badge--success kt-badge--inline kt-badge--pill">Active</span>';
					else
						$st='<span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill">Inactive</span>';
					
					if($r->premium==1)
						$prem='<span class="kt-badge kt-badge--danger ">P</span>';
					else
						$prem='<span class="kt-badge kt-badge--success ">F</span>';
					
					$uData['id'] = $r->id;
					$uData['uid'] = $r->unique_id;
					$uData['qpicon'] ='<img src="'.config('constants.file_path').$r->question_paper_icon.'" style="width:50px">';
					$uData['qpname'] =$r->question_paper_name."&nbsp;".$prem."<br>● ".$q_count ." Questions";
					$uData['cname'] = $r->course_name;
					$uData['ttime']="● ".$r->test_time." minutes<br>● Time: ".$r->start_time_text;
					$uData['tdate']=date_create($r->test_date)->format('d-m-Y');
					$uData['marks']="● Mark:&nbsp;".$r->question_mark."<br>● Neg:&nbsp;".$r->negative_mark;

					//$uData['desc'] =substr($r->description,0,80)."..more";*/
					//$uData['instruct'] =substr($r->instruction,0,80)."..more";*/
					$uData['status'] =$st;

					$btn='<a href="#" id="'.$r->id.'" class="edit btn bt-primary btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						 <a href="'.url('delete_live_qpaper').'/'.$r->id .'" class=" btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
					if($r->status==1)
						  $btn.='&nbsp;<a href="'.url('deactivate_live_qpaper').'/'.$r->id.'" class="btn bt-warning btn-secondary btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
					else
						 $btn.='&nbsp;<a href="'.url('activate_live_qpaper').'/'.$r->id.'" class="edit btn bt-success btn-secondary btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
					
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }

		return $data;
	}	


	public function getQuestionPaperBySubjectId($id)
	{
		$data=self::where('subject_id',$id)->get();
		return $data;
	}

	public function deleteQuestionPaper($id)
	{
		$dat=self::find($id);
		
		if(!empty($dat))
		{
		$fna=$dat->question_paper_icon;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		return $result??1;
	}
	
	 public function getQuestionPaperByCourseId($id)
	{
		$data=self::where('course_id',$id)->get();
		return $data;
	}
	
	
	
	
	
	
	
	
	
}

