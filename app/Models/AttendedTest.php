<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AttendedTest extends Model
{
    use HasFactory;
	
	//protected $table='questions';
	
    protected $fillable = [
      
    ];

    protected $hidden = [
       
    ];
		
	
 /*public function getStudentNames($request) //for test attede students report
  {
		
		$search=$request->search;
		$crsid=$request->course;
				
		$dts=Student::select('students.*')
		->leftJoin('purchased_packages','students.id','=','purchased_packages.student_id')
		->where('purchased_packages.course_unique_id',$crsid)
		->where(function($where) use($search)
			    {
					$where->where('students.name', 'like', '%' .$search . '%');
			    })->orderBy('students.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $key=>$r)
            {

			    $uData['no'] = ++$key;
				$uData['sname'] = '<a href="#" id="'.$r->id.'" class="lnkId" style="color:#2323d1;" >'.strtoupper($r->name).'</a>';
			    $data[] = $uData;
			}
        }

		return $data;
	}
	*/
	
public function getStudentNames($crsid) //for test attede students report
  {
		
		$dts=Student::select('students.*')
		->leftJoin('purchased_packages','students.id','=','purchased_packages.student_id')
		->where('purchased_packages.course_unique_id',$crsid)
		->orderBy('students.id','ASC')->get();
		
		$opt= '<option value="">--select--</option>';
        if(!empty($dts))
        {
			foreach ($dts as $key=>$r)
            {

			    $uData['no'] = ++$key;
				$opt.= '<option value="'.$r->id.'">'.strtoupper($r->name).'</option>';
			}
        }

		return $opt;
	}
	
	
	
  public function getTestDetails($request) //for test attede students report
  {
		$stid=$request->stid;
		
		$dts=McqTestResult::select('mcq_test_results.*','mcq_question_papers.question_paper_name')
		->leftJoin('mcq_question_papers','mcq_test_results.mcq_question_paper_id','=','mcq_question_papers.id')
		->where('mcq_test_results.student_id',$stid)
		->orderBy('mcq_test_results.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $key=>$r)
            {
				
				$mar= McqAllResult::select('subjects.subject_name')->where('mcq_question_paper_id',$r->mcq_question_paper_id)
				->leftJoin('subjects','mcq_all_results.subject_id','=','subjects.id')->get()->toArray();
				$tcnt=count($mar);
				
			    $uData['no'] = ++$key;
				$uData['subject'] =$mar[0]['subject_name'];
				$uData['qpaper'] =$r->question_paper_name;
				$uData['ntimes'] =$tcnt;
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	
}
