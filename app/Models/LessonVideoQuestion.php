<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonVideoQuestion extends Model
{
    use HasFactory;
	
	protected $table='lesson_video_questions';
	
    protected $fillable = [
      'video_id','question_mode','question_type','question','question_image',
	  'answer_1','answer_2','answer_3','answer_4','correct_answer','explanation','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions

	public function addLessonVideoQuestion($request)
	{
		
		$vid=$request->video_id;
		$qids=$request->quest_id;
		$q_ids=substr($qids,0,strlen($qids)-1);
		$questid=explode(",",$q_ids);

		foreach($questid as $qid)
		{
		   $qdt=(new Question())->getQuestionById($qid);
		
			$res=self::create([
			'video_id'=>$request->video_id,
			'question_type'=>$qdt->question_type,
			'question_mode'=>$qdt->question_mode,
			'question'=>$qdt->question,
			'question_image'=>$qdt->question_image,
			'answer_1'=>$qdt->answer_1,	
			'answer_2'=>$qdt->answer_2,	
			'answer_3'=>$qdt->answer_3,	
			'answer_4'=>$qdt->answer_4,	
			'correct_answer'=>$qdt->correct_answer,
			'explanation'=>$qdt->explanation,
			'status'=>1
			]);
		}
		
		return $res;
	}
		

	public function getVideoQuestions($request)
	{
		
		$vid=$request->searchByVideoId;
		$search=$request->search;
		
		$dts=self::select('lesson_video_questions.*','videos.title')
		->leftJoin('videos','lesson_video_questions.video_id','=','videos.id')
		->where('lesson_video_questions.video_id',$vid)
		->where(function($where) use($search)
			    {
					$where->where('lesson_video_questions.question', 'like', '%' .$search . '%')
					->orWhere('lesson_video_questions.answer_1', 'like', '%' .$search . '%')
					->orWhere('lesson_video_questions.question_mode', 'like', '%' .$search . '%')
					->orWhere('lesson_video_questions.question_type', 'like', '%' .$search . '%')
					->orWhere('lesson_video_questions.explanation', 'like', '%' .$search . '%');
			  })->orderBy('lesson_video_questions.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
				if($r->question!="")
				{
					$qst=$r->question;
					$qtype="Text";
				}	
				else
				{
					$qst='<img src="'.config('constants.file_path').$r->question_image.'" style="width:200px">';
					$qtype="Image";
				}
				
				if($r->question_mode==1)
				{
					$qmode="<span style='color:green'>Easy</span>";
				}	
				else if($r->question_mode==2)
				{
					$qmode="<span style='color:blue'>Medium</span>";
				}
				else
				{
					$qmode="<span style='color:red'>Difficult</span>";
				}
								
			    $uData['id'] = $r->id;
				$uData['vname']=$r->title;
				$uData['qtype']=$qtype;
				$uData['qmode']=$qmode;
				$uData['quest']=$qst;
				$uData['answer']="A - ".$r->answer_1."<br>B-".$r->answer_2."<br>C-".$r->answer_3."<br>D-".$r->answer_4;
				$uData['cans']=$r->correct_answer;
				$uData['expl']=$r->explanation;

				$btn='<a href="'.url('delete_video_question').'/'.$r->id.'" id="conf" class=" btn btn-danger btn-xs" style="padding:2px 2px 2px 7px;" title="Delete"><i class="fa fa-trash"></i></a>'; 
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function getVideoTotalQuestions($vid)
	{
		$qcount=self::where('video_id',$vid)->count();
		return $qcount;
	}
	
	public function getLessonVideoQuestions()
	{
		$data=self::orderBy('id','ASC')->get();
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
		
		if($dat->question_type==2)
		{
		$fna=$dat->question_image;
		Storage::disk('spaces')->delete($fna); 
		}
		
		$result=$dat->delete();
		return $result;
	}
		
	public function deleteQuestionByVideoId($vid)
	{
		$dat=self::where('video_id',$qpid)->get();
		foreach($dat as $r)
		{
			if($dat->question_type==2)
			 {
				$fna=$dat->question_image;
				Storage::disk('spaces')->delete($fna); 
			 }					
		}			
		
		$result=$dat->delete();
		return $result;
	}
	
	
	
}
