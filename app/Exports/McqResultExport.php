<?php

namespace App\Exports;

use App\Models\McqTestResult;
use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class McqResultExport implements FromCollection,WithHeadings
{
	//use Exportable;
		
	protected $qp_id =null;
		

	function __construct($qpid)
	{
		$this->qp_id=$qpid;
	}
	
	
    /**
    * @return \Illuminate\Support\Collection
    */
	  public function headings():array{
        return[
            'Slno',
			'Id',
            'Name',
            'Question_Paper',
			'Test_Date',
            'Answer',
            'Wrong',
            'Skipped',
            'Marks',
            'Score',
            'Rank'
        ];
    } 
	
	
    public function collection()
    {
		$qpid=$this->qp_id;
		
        $rank_list=McqTestResult::select('mcq_test_results.*','students.name','mcq_question_papers.question_paper_name')
				->leftJoin('students','mcq_test_results.student_id','=','students.id')
				->leftJoin('mcq_question_papers','mcq_test_results.mcq_question_paper_id','=','mcq_question_papers.id')
				->where('mcq_question_paper_id',$qpid)->get()->toArray();
		
		$last_v=0;$i=0;
			usort($rank_list,array($this,'sortByMark'));
			
				foreach ($rank_list as $m => $v) 
				{
						if ($v['score'] != $last_v)
						{
						   $i++;
						   $last_v = $v['score'];
						}
					  $rank_list[$m]['student_id'] = $v['student_id'];
					  $rank_list[$m]['rank'] = $i;
				}
	
		$data = array();
		$uData = array();
		
		$rank_list=collect($rank_list)->sortBy('rank')->toArray();
				
        if(!empty($rank_list))
        {
			foreach ($rank_list as $key=>$r)
            {
				$uData['slno'] = ++$key;
				$uData['id'] = $r['student_id'];
				$uData['name'] =$r['name'];
				$uData['qpname'] =$r['question_paper_name'];
				$uData['tdate'] =date_create($r['test_date'])->format('d-m-Y');
				$uData['answer']=$r['answer'];
				$uData['wrong']=$r['wrong'];
				$uData['skipped']=$r['skipped'];
				$uData['mark']=$r['marks'];
				$uData['score']=$r['score'];
				$uData['rank']=$r['rank'];
						
			    $data[] = $uData;
			}
        }
		
		return collect($data);   //to convert array to collection

		//return McqTestResult::all();
    }
	
	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}
	
	
	
}
