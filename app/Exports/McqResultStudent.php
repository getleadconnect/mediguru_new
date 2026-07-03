<?php

namespace App\Exports;

use App\Models\McqTestResult;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class McqResultStudent implements FromCollection,WithHeadings
{
	//use Exportable;
		
	protected $stud_id =null;
		

	function __construct($stid)
	{
		$this->stud_id=$stid;
	}
	
	
    /**
    * @return \Illuminate\Support\Collection
    */
	  public function headings():array{
        return[
            'Id',
            'Name',
            'Question_Paper',
			'Test_Date',
            'Answer',
            'Wrong',
            'Skipped',
            'Marks',
            'Score',
        ];
    } 
	
	
    public function collection()
    {
		$stid=$this->stud_id;
		
        $mtdat=McqTestResult::select('mcq_test_results.*','students.name','mcq_question_papers.question_paper_name')
				->leftJoin('students','mcq_test_results.student_id','=','students.id')
				->leftJoin('mcq_question_papers','mcq_test_results.mcq_question_paper_id','=','mcq_question_papers.id')
				->where('mcq_test_results.student_id',$stid)->get();
				
		$data = array();
		$uData = array();

        if(!empty($mtdat))
        {
			foreach ($mtdat as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['name'] =$r->name;
				$uData['qpname'] =$r->question_paper_name;
				$uData['tdate'] =date_create($r->test_date)->format('d-m-Y');
				$uData['answer']=$r->answer;
				$uData['wrong']=$r->wrong;
				$uData['skipped']=$r->skipped;
				$uData['mark']=$r->marks;
				$uData['score']=$r->score;
					
			    $data[] = $uData;
			}
        }		
				

		return collect($data);   

		//return McqTestResult::all();
    }

	
}
