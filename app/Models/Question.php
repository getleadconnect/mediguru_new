<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Question extends Model
{
    use HasFactory;
	
	protected $table='questions';
	
    protected $fillable = [
      'qb_subject_id','question_mode','question_type','question','question_image',
	  'answer_1','answer_2','answer_3','answer_4','correct_answer','explanation','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'subject_id'=>'required',
	'question_type'=>'required',
	//'question'=>'required',
	//'question_image'=>'required',
	'answer1'=>'required',	
	'answer2'=>'required',	
	'answer3'=>'required',	
	'answer4'=>'required',	
	'correct_answer'=>'required',
	];
	
		
	public function addQuestion($request)
	{
		
		$fname="";
		
		if($request->file('question_image'))
		{
				$ext=$request->file('question_image')->getClientOriginalExtension();	 
				$filename = "qes_".date('Ymdhis').".".$ext;
				$fname ="mediguru/question_images/".$filename;
				Storage::disk('spaces')->putFileAs("mediguru/question_images",$request->file('question_image'), $filename, 'public');
		}
						
		return self::create([
		'qb_subject_id'=>$request->subject_id,
		'question_type'=>$request->question_type,
		'question_mode'=>$request->question_mode,
		'question'=>$request->question,
		'question_image'=>$fname,
		'answer_1'=>$request->answer1,	
		'answer_2'=>$request->answer2,	
		'answer_3'=>$request->answer3,	
		'answer_4'=>$request->answer4,	
		'correct_answer'=>$request->correct_answer,
		'explanation'=>$request->explanation,
		'status'=>1
		]);
		
	}
		
	public function updateQuestion($request)
	{
		
		$fname=$request->quest_image;
		$id=$request->quest_id;

		if($request->file('question_image'))
		{
			$dat=self::find($id);
			$fna=$dat->question_image;
			
			$ext=$request->file('question_image')->getClientOriginalExtension();	 
			$filename = "qes_".date('Ymdhis').".".$ext;
			$fname ="mediguru/question_images/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/question_images",$request->file('question_image'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna); 
		}
		
		$dat=[
		'qb_subject_id'=>$request->subject_id,
		'question_type'=>$request->question_type,
		'question'=>$request->question,
		'question_image'=>$fname,
		'answer_1'=>$request->answer1,	
		'answer_2'=>$request->answer2,	
		'answer_3'=>$request->answer3,	
		'answer_4'=>$request->answer4,	
		'correct_answer'=>$request->correct_answer,
		'explanation'=>$request->explanation,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	
	public function getQuestions($request)
	{
		$subid=$request->searchBySubject;
		$search=$request->search;
		
		$dts=self::select('questions.*','qb_subjects.subject_name')
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
		
		$dats=$dts->orderBy('questions.id','ASC')->get();
					
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
				if($r->status==1)
				$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
				
				if($r->question!="")
				{
					$qst=$r->question;
				}	
				else
				{
					$qst='<img src="'.config('constants.file_path')."/".$r->question_image.'" style="width:200px">';
				}
				
			    $uData['id'] = $r->id;
				$uData['subject']=$r->subject_name;
				$uData['quest']=$qst;
				$uData['answer']="A - ".$r->answer_1."<br>B-".$r->answer_2."<br>C-".$r->answer_3."<br>D-".$r->answer_4;
				$uData['cans']=$r->correct_answer;
				$uData['expl']=$r->explanation;
				$uData['status']=$st;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="'.url('delete_question').'/'.$r->id.'" id="conf" class=" btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
				if($r->status==1)
					  $btn.='<a href="'.url('deactivate_question').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_question').'/'.$r->id.'" class="btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}


	public function getQuestionPapers()
	{
		$data=QuestionPaper::orderBy('id','ASC')->get();
		return $data;
	}
	
	
	public function getQuestionById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteQuestion($id)
	{
		$dat=self::find($id);
		$fna=$dat->question_image;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the space
		return $result;
	}
	
	
}
