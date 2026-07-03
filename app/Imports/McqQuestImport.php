<?php

namespace App\Imports;

use App\Models\McqQuestion;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class McqQuestImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

	protected $qpaper_id =null;
	
	function __construct($qpid)
	{
		$this->qpaper_id=$qpid;
	}

    public function model(array $row)
    {
        if($row['question']!="")
		{
			if(strtoupper($row['question_mode'])=="EASY")
			{$qmode=1;}
			else if(strtoupper($row['question_mode'])=="MEDIUM")
			{ $qmode=2; }
			else if(strtoupper($row['question_mode'])=="DIFFICULT")
			{ $qmode=3; }
			
			return new McqQuestion([
				'question_paper_id'=>$this->qpaper_id,
				'question_type'=>1,
				'question'=>$row['question'],
				'question_mode'=>$qmode,
				'answer_1'=>$row['answer1'],	
				'answer_2'=>$row['answer2'],	
				'answer_3'=>$row['answer3'],	
				'answer_4'=>$row['answer4'],
				'correct_answer'=>$row['correct_answer'],
				'explanation'=>$row['explanation'],
				'status'=>1
			]);
		}
		
    }

}
