<?php

namespace App\Imports;

use App\Models\Question;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

	protected $subject_id =null;
		

	function __construct($subid)
	{

		$this->subject_id=$subid;

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
			
			
			return new Question([

				'qb_subject_id'=>$this->subject_id,
				'question'=>$row['question'],
				'question_type'=>1,
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
