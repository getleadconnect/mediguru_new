<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqQuestion extends Model
{
    use HasFactory;
	
	protected $table='mcq_questions';
	
    protected $fillable = [
      'mcq_question_paper_id','question_mode','question_type','question','question_image',
	  'answer_1','answer_2','answer_3','answer_4','correct_answer','explanation','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions

	public function addMcqQuestion($request)
	{
		
		$qpid=$request->qpaper_id;
		$qids=$request->quest_id;
		$q_ids=substr($qids,0,strlen($qids)-1);
		$questid=explode(",",$q_ids);

		foreach($questid as $qid)
		{
		   $qdt=(new Question())->getQuestionById($qid);
		
			$res=self::create([
			'mcq_question_paper_id'=>$request->qpaper_id,
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
		

	public function getMcqQuestions($request)
	{
		
		$qpid=$request->searchByQpaper;
		$search=$request->search;
		
		
		$dts=self::select('mcq_questions.*','mcq_question_papers.question_paper_name')
		->leftJoin('mcq_question_papers','mcq_questions.mcq_question_paper_id','=','mcq_question_papers.id')
		->where('mcq_questions.mcq_question_paper_id',$qpid)
		->where(function($where) use($search)
			    {
					$where->where('mcq_questions.question', 'like', '%' .$search . '%')
					->orWhere('mcq_questions.answer_1', 'like', '%' .$search . '%')
					->orWhere('mcq_questions.question_mode', 'like', '%' .$search . '%')
					->orWhere('mcq_questions.question_type', 'like', '%' .$search . '%')
					->orWhere('mcq_questions.explanation', 'like', '%' .$search . '%');
			  })->orderBy('mcq_questions.id','ASC')->get();
		
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
				$uData['qtype']=$qtype;
				$uData['qmode']=$qmode;
				$uData['quest']=$qst;
				$uData['answer']="A - ".$r->answer_1."<br>B-".$r->answer_2."<br>C-".$r->answer_3."<br>D-".$r->answer_4;
				$uData['cans']=$r->correct_answer;
				$uData['expl']=$r->explanation;

				$btn='<a href="'.url('delete_mcqquestion').'/'.$r->id.'" id="conf" class=" btn btn-danger btn-xs" style="padding:2px 2px 2px 7px;" title="Delete"><i class="fa fa-trash"></i></a>'; 
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function getTotalQuestions($qpid)
	{
		$qcount=self::where('mcq_question_paper_id',$qpid)->count();
		return $qcount;
	}
	
	public function getQuestionPapers()
	{
		$data=McqQuestionPaper::orderBy('id','ASC')->get();
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
		
	public function deleteQuestionByQpaperId($qpid)
	{
		$dat=self::where('mcq_question_paper_id',$qpid)->get();
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
	
	
	// for analytics --------------------------------------------------------------
	
	public function get_qpaper_questions($request)
	{
		
		$qpid=$request->searchByQpid;
		$search=$request->search;
				
		$dts=self::select('mcq_questions.*','mcq_question_papers.question_paper_name')
		->leftJoin('mcq_question_papers','mcq_questions.mcq_question_paper_id','=','mcq_question_papers.id')
		->where('mcq_questions.mcq_question_paper_id',$qpid)
		->where(function($where) use($search)
			    {
					$where->where('mcq_questions.question', 'like', '%' .$search . '%')
					->orWhere('mcq_questions.question_mode', 'like', '%' .$search . '%');
			  })->orderBy('mcq_questions.id','ASC')->get();
		
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
				$uData['quest']=$qst;
				$uData['qmode']=$qmode;
				$btn='<a href="#" id="'.$r->id.'" class="attendies btn btn-info btn-xs sharp mr-1" style="padding:5px 7px 5px 7px;" title="get attended students">Get</a>'; 
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	
}
