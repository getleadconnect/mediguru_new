<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Material;

class LessonMcqTest extends Model
{
    use HasFactory;
	
	protected $table='lesson_mcq_tests';
	
    protected $fillable = [
      'subject_id','lesson_id','mcq_unique_id','order_no'
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public function addLessonMcqTest($request)  
	{
		return self::create([
			'subject_id'=>$request->subject_id,
			'lesson_id'=>$request->lesson_id,
			'mcq_unique_id'=>$request->unique_id,
		]);
	}
	
	
	public function viewLessonMcqQpapers($request)  //for view lesson question papers
	{
		
		$search=$request->search;
				
		$dts=self::select('lesson_mcq_tests.*','mcq_question_papers.question_paper_icon','mcq_question_papers.question_paper_name','subjects.subject_name','lessons.lesson_name',)
		->leftJoin('mcq_question_papers','lesson_mcq_tests.mcq_unique_id','=','mcq_question_papers.unique_id')
		->leftJoin('lessons','lesson_mcq_tests.lesson_id','=','lessons.id')
		->leftJoin('subjects','lesson_mcq_tests.subject_id','=','subjects.id')
		
		->where('mcq_question_papers.question_paper_type','1')
		->where(function($where) use($search)
			  {
				$where->where('mcq_question_papers.question_paper_name', 'like', '%' .$search . '%')
				->orWhere('lessons.lesson_name', 'like', '%' .$search . '%')
				->orWhere('subjects.subject_name', 'like', '%' .$search . '%');
			  });

		$dats=$dts->orderBy('id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['uid'] =$r->mcq_unique_id;
				$uData['icon'] ='<img src="'.config('constants.file_path').$r->question_paper_icon.'" style="width:50px;">';
				$uData['title'] =$r->question_paper_name;
				$uData['sname'] =$r->subject_name;
				$uData['lname'] =$r->lesson_name;
				
				$btn='<a href="#" id="'.$r->id.'" class=" btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

//---------------------------------------------------
			
	public function viewMcqQpapers($request)  //for prepare lesson question papers
	{
		
		$search=$request->search;
		$sbcourse=$request->searchByCourse;
				
		$dts=McqQuestionPaper::select('mcq_question_papers.*')->where('question_paper_type','1')
		->where('mcq_question_papers.course_id',$sbcourse)
		->where(function($where) use($search)
			    {
					$where->where('mcq_question_papers.question_paper_name', 'like', '%' .$search . '%')
					->orWhere('mcq_question_papers.unique_id', 'like', '%' .$search . '%');
			  });
				
		$dats=$dts->orderBy('id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['uid'] =$r->unique_id;
				$uData['vicon'] ='<img src="'.config('constants.file_path').$r->question_paper_icon.'" style="width:50px;">';
				$uData['title'] =$r->question_paper_name;

				//$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					// <a href="#" id="'.$r->id.'" class=" btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				//$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	//--------------------------
		
	public function LessonMcqTests($request)  //get lesson items
	{
		$search=$request->search;
		$lesid=$request->searchByLesson;
		
		$dats=self::select('lesson_mcq_tests.*','mcq_question_papers.question_paper_name','mcq_question_papers.question_paper_icon')
		->leftJoin('mcq_question_papers','lesson_mcq_tests.mcq_unique_id','=','mcq_question_papers.unique_id')
		->where('lesson_mcq_tests.lesson_id',$lesid)
		->where(function($where) use($search)
			    {
					$where->where('mcq_question_papers.question_paper_name', 'like', '%' .$search . '%')
					->orWhere('mcq_question_papers.unique_id', 'like', '%' .$search . '%');
			  })->orderBy('lesson_mcq_tests.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
			    $uData['id'] = ++$key;
				$uData['icon'] ='<img src="'.config('constants.file_path').$r->question_paper_icon.'" style="width:50px;">';
				$uData['dat'] ="<span style='font-size:12px;'>Uid : ".$r->mcq_unique_id."</b><br>Q_Paper : ".$r->question_paper_name."</span>";
				
				if($r->order_no!="")
				{		
					$ordn=$r->order_no;
					$ordn.='&nbsp;<a href="#" id="'.$r->id.'" class="btnOrder btn  btn-elevate btn-circle btn-icon" data-toggle="modal" data-target="#kt_modal_3" style="width:1.75rem;height:1.75rem;" title="Add/Change"><i class="fa fa-edit" style="color:#637ddb;"></i></a>';
				}
				else
				{
					$ordn='<a href="#" id="'.$r->id.'" class="btnOrder btn  btn-elevate btn-circle btn-icon" data-toggle="modal" data-target="#kt_modal_3" style="width:1.75rem;height:1.75rem;" title="Add/Change"><i class="fa fa-edit" style="color:#637ddb;"></i></a>';
				}
				
				$uData['ord'] = $ordn;
								
				$uData['action'] ='<a href="#" id="'.$r->id.'" class="btnDel btn btn-danger btn-elevate btn-circle btn-icon" style="width:1.75rem;height:1.75rem;" title="Delete"><i class="fa fa-trash"></i></a>';
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function getLessonMcqTests()
	{
		$data=self::select('lesson_mcq_tests.*')->orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getLessonMcqTestById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function deleteLessonMcqTest($id)
	{
		$dat=self::find($id);
		$result='';
		if(!empty($dat))
		{
		  $result=$dat->delete();
		}
		return $result;
	}
		
	
	
}
