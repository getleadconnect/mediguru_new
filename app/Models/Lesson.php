<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class Lesson extends Model   //chapters
{
    use HasFactory;
	
	protected $table='lessons';
	
    protected $fillable = [
      'course_id','subject_id','lesson_name','lesson_icon','order_no','status',
    ];


    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'lesson_name'=>'required',
	'subject_id'=>'required',
	'lesson_icon'=>'required',
	'order_no'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_course_id'=>'required',
	'ed_lesson_name'=>'required',
	'ed_subject_id'=>'required',
	'ed_order_no'=>'required',
	];
		
	public function addLesson($request)
	{
		
		$fname="";
		if($request->file('lesson_icon'))
		{

			$ext=$request->file('lesson_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/lesson_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/lesson_icons",$request->file('lesson_icon'), $filename, 'public');
		}
		
		return self::create([
			'course_id'=>$request->course_id,
			'subject_id'=>$request->subject_id,
			'lesson_name'=>$request->lesson_name,
			'lesson_icon'=>$fname,
			'order_no'=>$request->order_no,
			'status'=>1
		]);
		
	}
	
		
	
	public function updateLesson($request)
	{
		
		$fname=$request->ed_les_icon;
		
		$id=$request->ed_les_id;
		
		if($request->file('ed_lesson_icon'))
		{

			$dat=self::find($id);
			$fna=$dat->chapter_icon;

			$ext=$request->file('ed_lesson_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/lesson_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/lesson_icons",$request->file('ed_lesson_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$dat=[
		'course_id'=>$request->ed_course_id,
		'subject_id'=>$request->ed_subject_id,
		'lesson_name'=>$request->ed_lesson_name,
		'lesson_icon'=>$fname,
		'order_no'=>$request->ed_order_no,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getLessons()
	{
		$data=self::select('lessons.*')->orderBy('id','ASC')->get();
		return $data;
	}
	
	public function viewLessons($request)
	{
		$search=$request->search;
		$crsid=$request->searchBycourse;
		$scrsid=$request->searchBySubcourse;
				
		$dts=self::select('lessons.*','courses.course_name','subjects.subject_name')
		->leftJoin('courses','lessons.course_id','=','courses.id')
		->leftJoin('subjects','lessons.subject_id','=','subjects.id')
		->where(function($where) use($search)
			    {
					$where->where('lessons.lesson_name', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('subjects.subject_name', 'like', '%' .$search . '%');
			  });
		
		if($crsid!="" and $scrsid!="")
		{
			$dts->where('lessons.course_id',$crsid)->where('lessons.subject_id',$scrsid);
		}
		
		$dats=$dts->orderBy('lessons.id','ASC')->get();
		
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
				
			    $uData['id'] = $r->id;
				$uData['cicon'] ='<img src="'.config('constants.file_path').$r->lesson_icon.'" style="width:60px">';
				$uData['cname'] =$r->course_name;
				$uData['sname'] =$r->subject_name;
				$uData['lname'] =$r->lesson_name;
				$uData['ordno'] =$r->order_no;
				$uData['status'] =$st;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" class=" btndel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				if($r->status==1)
					  $btn.='<a href="#" id="'.$r->id.'/2" class="btnActDeact btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="#" id="'.$r->id.'/1" class="btnActDeact btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	public function getLessonById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function getLessonsBySubjectId($id)
	{
		$data=self::where('subject_id',$id)->orderBy('id','ASC')->get();
		return $data;
	}	
	
	public function deleteLesson($id)
	{
		$dat=self::find($id);
		$fna=$dat->lesson_icon;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
}
