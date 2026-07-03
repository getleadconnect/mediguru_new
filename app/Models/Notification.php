<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class Notification extends Model
{
    use HasFactory;
	
	protected $table='notifications';
	
    protected $fillable = [
      'course_unique_id','subject_id','title','message','message_type','status'
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public const RULES=[
	'title'=>'required',
	'message'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_title'=>'required',
	'ed_message'=>'required',
	];
	
	
	public function addNotification($request)  
	{

		return self::create([
			'added_date'=>date('Y-m-d'),
			'course_unique_id'=>$request->course_unique_id,
			'subject_id'=>$request->subject_id,
			'title'=>$request->title,
			'message'=>$request->message,
			'message_type'=>$request->message_type,
			'status'=>1,
		]);
	}
	
	
	public function viewNotifications($request)
	{
		
		$search=$request->search;

		$dts=self::select('notifications.*','courses.course_name','subjects.subject_name')
		->leftJoin('courses','notifications.course_unique_id','=','courses.unique_id')
		->leftJoin('subjects','notifications.subject_id','=','subjects.id')
		->where(function($where) use($search)
			{
				$where->where('notifications.title', 'like', '%' .$search . '%')
				->orWhere('courses.course_name', 'like', '%' .$search . '%')
				->orWhere('subjects.subject_name', 'like', '%' .$search . '%');
			});
		
		$dats=$dts->orderBy('notifications.id','ASC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$mt='';$ty="";

				if($r->status==1)
					$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else
					$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';

				$action='<a href="#" id="'.$r->id.'"  class="btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;';

				$btn='';
				if($r->status==1)
					  $btn.='<a href="#" id="'.$r->id.'" rel="2" class="btnActDeact btn  btn-warning btn-circle btn-icon" title="Deactivate" ><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="#" id="'.$r->id.'" rel="1" class="btnActDeact btn btn-success btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				
			    $uData['id'] = ++$key;

				$uData['cname']=$r->course_name;
				$uData['sub'] =$r->subject_name; 
				
				if($r->message_type==1)
				{
					$uData['cname']="-----"; $uData['sub'] ="-----"; 
					$ty='<span class="kt-badge kt-badge--warning kt-badge--inline kt-badge--pill">General</span>';	
				}
				else if($r->message_type==2)
				{
					$ty='<span class="kt-badge kt-badge--primary  kt-badge--inline kt-badge--pill">Subject</span>';	
				}
				else if($r->message_type=3){ 
					$uData['sub']="-----";
					$ty='<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">Course</span>';
				} 

				$uData['adt'] = date_create($r->added_date)->format('d-m-Y');
				$uData['tit'] = $r->title;
				$uData['mes'] = $r->message;
				$uData['type'] =$ty;
				$uData['status'] =$st;
				$uData['action'] =$action.$btn;

			    $data[] = $uData;
			}
        }

		return $data;
	}
	
public function deleteNotification($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}



	
}
