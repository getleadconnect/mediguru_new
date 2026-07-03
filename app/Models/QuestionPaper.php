<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;

use \Carbon\carbon;

class QuestionPaper extends Model
{
    use HasFactory;
	
	protected $table='question_papers';
	
    protected $fillable = [
      'course_id','subject_id','package_id','question_paper_type','question_paper_name',
	  'premium','description','instruction','test_time','schedule_date','test_date','start_time',
	  'start_time_text','question_paper_icon','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'subject_id'=>'required',
	'package_id'=>'required',
	'premium'=>'required',
	'question_paper_type'=>'required',
	'question_paper_name'=>'required',
	'question_paper_icon'=>'required',
	'test_time'=>'required',
	];
	
	public const EDIT_RULES=[
	'course_id'=>'required',
	'subject_id'=>'required',
	'package_id'=>'required',
	'premium'=>'required',
	'question_paper_name'=>'required',
	'test_time'=>'required',
	'instruction'=>'required'
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
			'subject_id'=>$request->subject_id,
			'package_id'=>$request->package_id,
			'question_paper_name'=>$request->question_paper_name,
			'question_paper_type'=>$request->question_paper_type,
			'premium'=>$request->premium,
			'description'=>$request->description,
			'instruction'=>$request->instruction,
			'question_paper_icon'=>$fname,
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
			$filename = "st_".date('Ymdhis').".".$ext;
			$fname ="mediguru/qpaper_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/qpaper_icons",$request->file('question_paper_icon'), $filename, 'public');

			Storage::disk('spaces')->delete($fna);  //delete file from the disk

		}
						
		$dat=[
			'course_id'=>$request->course_id,
			'subject_id'=>$request->subject_id,
			'package_id'=>$request->package_id,
			'question_paper_name'=>$request->question_paper_name,
			//'question_paper_type'=>$request->question_paper_type,
			'premium'=>$request->premium,
			'description'=>$request->description,
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
		$data=self::select('question_papers.*','courses.course_name','subjects.subject_name')
		->leftJoin('courses','question_papers.course_id','=','courses.id')
		->leftJoin('subjects','question_papers.subject_id','=','subjects.id')
		->where('question_papers.id',$id)->first();
		
		return $data;
	}
	
  public function getQuestionPapers($request,$qpaper_type)  //view data
	{
		$search=$request->search;
	
		$dts=self::select('question_papers.*','courses.course_name','subjects.subject_name','packages.package_name')
		->leftJoin('courses','question_papers.course_id','=','courses.id')
		->leftJoin('subjects','question_papers.subject_id','=','subjects.id')
		->leftJoin('packages','question_papers.package_id','=','packages.id')
		->where('question_papers.question_paper_type',$qpaper_type)
		->where(function($where) use($search)
			    {
					$where->where('question_papers.question_paper_name', 'like', '%' .$search . '%')
					->orWhere('question_papers.test_time', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('subjects.subject_name', 'like', '%' .$search . '%')
					->orWhere('packages.package_name', 'like', '%' .$search . '%');
			  })->orderBy('question_papers.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {

				if($r->question_paper_type==1)
				{
					
					$q_count=McqQuestion::where('question_paper_id',$r->id)->count();
					
					if($r->status==1)
						$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
					else
						$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
					
					if($r->premium==1)
						$prem='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">P</span>';
					else
						$prem='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">F</span>';
					
					$uData['id'] = $r->id;
					$uData['qpicon'] ='<img src="'.config('constants.file_path').$r->question_paper_icon.'" style="width:50px">';
					$uData['qpname'] =$r->question_paper_name."&nbsp;".$prem."<br>● ".$q_count ." Questions";
					$uData['course']="<b>C: </b>".$r->course_name."<br><b>S: </b>".$r->subject_name;   

					$uData['ttime']=$r->test_time." Minutes";
					if($r->schedule_date!="")
					  {
						$uData['ttime'].="<br><span style='color:#d330f1;'>Scheduled<br>".date_create($r->schedule_date)->format('d-m-Y')."</span>";
					  }
					
					$uData['pkg']=$r->package_name;
					//$uData['desc'] =substr($r->description,0,80)."..more";*/
					//$uData['instruct'] =substr($r->instruction,0,80)."..more";*/
					$uData['status'] =$st;

					$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
						 <a href="'.url('delete_qpaper').'/'.$r->id .'" class=" btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
					if($r->status==1)
						  $btn.='<a href="'.url('deactivate_qpaper').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
					else
						 $btn.='<a href="'.url('activate_qpaper').'/'.$r->id.'" class="edit btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
					
					$uData['action'] = $btn;
				}
				
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

