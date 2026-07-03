<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Material;
use App\Models\McqQuestionPaper;

class DashLiveMockTest extends Model
{
    use HasFactory;
	
	protected $table='dash_live_mock_tests';
	
    protected $fillable = [
      'added_date','course_id','subject_id','live_unique_id',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public function addLiveMockTest($request)  
	{
		return self::create([
			'added_date'=>date('Y-m-d'),
			'course_id'=>$request->courseid,
			'live_unique_id'=>$request->qp_unique_id,
			'subject_id'=>$request->subjectid,
		]);
	}
	
	public function getLiveQpapersByCourseId($id)
	{
		$result=McqQuestionPaper::where('course_id',$id)
		->where('question_paper_type',2)->orderBy('test_date','ASC')->get();
		return $result;
		
	}
	
	public function viewDashLiveMockTestQpapers($request)  //for view lesson question papers
	{

		$search=$request->search;
			
		$dts=self::select('dash_live_mock_tests.*','mcq_question_papers.test_date','mcq_question_papers.start_time_text','mcq_question_papers.question_paper_icon','mcq_question_papers.question_paper_name','subjects.subject_name','courses.course_name',)
		->leftJoin('mcq_question_papers','dash_live_mock_tests.live_unique_id','=','mcq_question_papers.unique_id')
		->leftJoin('courses','dash_live_mock_tests.course_id','=','courses.id')
		->leftJoin('subjects','dash_live_mock_tests.subject_id','=','subjects.id')
		->where('mcq_question_papers.question_paper_type','2')
		->where(function($where) use($search)
			  {
				$where->where('mcq_question_papers.question_paper_name', 'like', '%' .$search . '%')
				->orWhere('courses.course_name', 'like', '%' .$search . '%')
				->orWhere('subjects.subject_name', 'like', '%' .$search . '%');
			  });

		$dats=$dts->orderBy('id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
			    $uData['id'] = ++$key;
				$uData['uid'] =$r->live_unique_id;
				$uData['icon'] ='<img src="'.config('constants.file_path').$r->question_paper_icon.'" style="width:50px;">';
				$uData['sname'] =$r->subject_name;
				$uData['tdate'] ="Date: ".$r->test_date."<br>Time: ".$r->start_time_text;
				$uData['cname'] =$r->course_name;
				$uData['qpaper'] =$r->question_paper_name;
				
				$btn='<a href="#" id="'.$r->id.'" class=" btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}


	
	public function deleteDashLiveTest($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}
	
}
