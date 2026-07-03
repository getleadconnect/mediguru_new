<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;

use Carbon\Carbon;

class McqQuestionPaper extends Model
{
    use HasFactory;
	
	protected $table='mcq_question_papers';
	
     protected $fillable = [
     'course_id','unique_id','question_paper_name','question_paper_type','premium','description','instruction','test_time',
	  'schedule_date','test_date','start_time','start_time_text','question_paper_icon','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	/*protected $casts = [
        'start_time',
		'start_time_text',
    ];*/
	
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'premium'=>'required',
	'unique_id'=>'required',
	'question_paper_name'=>'required',
	'question_paper_icon'=>'required',
	'test_time'=>'required',
	];
	
	public const EDIT_RULES=[
	'course_id'=>'required',
	'premium'=>'required',
	'unique_id'=>'required',
	'question_paper_name'=>'required',
	'test_time'=>'required',
	'instruction'=>'required'
	];
			
	public function addQuestionPaper($request,$qptype)
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
			'premium'=>$request->premium,
			'instruction'=>$request->instruction,
			'question_paper_icon'=>$fname,
			'question_paper_type'=>$qptype,
			'test_time'=>$request->test_time,
			'schedule_date'=>$request->schedule_date,
			'test_date'=>$tdate,
			'start_time'=>$stime,
			'start_time_text'=>$sttime,
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
					
			Storage::disk('spaces')->delete($fna);  //delete file from the space
		}
						
		$dat=[
			'course_id'=>$request->course_id,
			'unique_id'=>$request->unique_id,
			'question_paper_name'=>$request->question_paper_name,
			'premium'=>$request->premium,
			'instruction'=>$request->instruction,
			'question_paper_icon'=>$fname,
			'test_time'=>$request->test_time,
			'schedule_date'=>$request->schedule_date,
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
		
	public function getQuestionPaperByCourseId($id)
	{
		$data=self::select('mcq_question_papers.*')->where('mcq_question_papers.course_id',$id)->get();
		return $data;
	}
	
	public function getMcqQPapers()
	{
		$data=self::select('mcq_question_papers.*')->orderBy('id','ASC')->get();
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
						$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
					else
						$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
					
					if($r->premium==1)
						$prem='<span class="kt-badge kt-badge--danger">P</span>';
					else
						$prem='<span class="kt-badge kt-badge--info">F</span>';
					
					$uData['id'] = $r->id;
					$uData['uid'] = $r->unique_id;
					$uData['cname'] = $r->course_name;
					$uData['qpicon'] ='<img src="'.config('constants.file_path').$r->question_paper_icon.'" style="width:50px">';
					$uData['qpname'] =$r->question_paper_name."&nbsp;".$prem."<br>● ".$q_count ." Questions";

					$uData['ttime']=$r->test_time." Minutes";
					
					if($r->schedule_date!="")
					  {
						$uData['ttime'].="<br><span style='color:#d330f1;'>Dt: ".date_create($r->schedule_date)->format('d-m-Y')."</span>";
					  }
					//$uData['desc'] =substr($r->description,0,80)."..more";*/
					//$uData['instruct'] =substr($r->instruction,0,80)."..more";*/
					$uData['status'] =$st;

					$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						 <a href="'.url('delete_mcq_qpaper').'/'.$r->id .'" class=" btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
					if($r->status==1)
						  $btn.='<a href="'.url('deactivate_mcq_qpaper').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
					else
						 $btn.='<a href="'.url('activate_mcq_qpaper').'/'.$r->id.'" class="edit btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
					
					$uData['action'] = $btn;

			    $data[] = $uData;
			}
        }

		return $data;
	}
		

	public function deleteQuestionPaper($id)
	{
		$dat=self::find($id);
		
		if(!empty($dat))
		{
		$fna=$dat->question_paper_icon;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);
		}
		
		return $result??1;
	}

	
}

