<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SubjectLiveClass extends Model
{
    use HasFactory;
	
	protected $table='subject_live_class';
	
    protected $fillable = [
      'added_date','course_id','subject_id','display_order','class_link','chat_link','class_date','title','description','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'subject_id'=>'required',
	'class_title'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_course_id'=>'required',
	'ed_subject_id'=>'required',
	'ed_class_title'=>'required',
	];

	public function addSubjectLiveClass($request)
	{
		return self::create([
		'added_date'=>date('Y-m-d'),
		'course_id'=>$request->course_id,
		'subject_id'=>$request->subject_id,
		'class_date'=>$request->class_date,
		'display_order'=>$request->display_order,
		'class_link'=>$request->class_link,
		'chat_link'=>$request->chat_link,
		'title'=>$request->class_title,
		'description'=>$request->description,
		'status'=>1
		]);
	}
		
	public function updateSubjectLiveClass($request)
	{
		
		$id=$request->ed_live_class_id;
						
		$dat=[
		'course_id'=>$request->ed_course_id,
		'subject_id'=>$request->ed_subject_id,
		'class_date'=>$request->ed_class_date,
		'display_order'=>$request->ed_display_order,
		'class_link'=>$request->ed_class_link,
		'chat_link'=>$request->ed_chat_link,
		'title'=>$request->ed_class_title,
		'description'=>$request->ed_description,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getSubjectLiveClass()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getSubjectLiveClassById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteSubjectLiveClass($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

	public function viewSubjectLiveClass($request)  //for view lesson question papers
	{

		$search=$request->search;
			
		$dts=self::select('subject_live_class.*','courses.course_name','subjects.subject_name',)
		->leftJoin('courses','subject_live_class.course_id','=','courses.id')
		->leftJoin('subjects','subject_live_class.subject_id','=','subjects.id')
		->where(function($where) use($search)
			  {
				$where->where('subject_live_class.title', 'like', '%' .$search . '%')
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
			    if($r->status==1)
				$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
			
				
																
				$uData['slno'] = ++$key;
				$uData['cname'] ="C: ".$r->course_name."<br>S: ".$r->subject_name;
				$uData['title'] ="Title: ".$r->title."<br>Link: <span style='color:blue;'>".$r->class_link."</span>
				<br>Chat:<span style='color:blue;'>".$r->chat_link."</span><br>Desc:".$r->description;
				
				$uData['dat'] ="Date: <span style='color:#d519e1;'>".$r->class_date."</span><br>Order:<b>".$r->display_order;
				$uData['status'] =$st;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" id="conf" class=" btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				if($r->status==1)
					  $btn.='&nbsp;<a href="#" rel=2 id="'.$r->id.'" class="act_deact btn btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='&nbsp;<a href="#" rel=1 id="'.$r->id.'" class="act_deact btn btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	

				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	
	
}
