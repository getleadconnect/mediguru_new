<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Package; 

class Subject extends Model
{
    use HasFactory;
	
	protected $table='subjects';
	
    protected $fillable = [
      'course_id','course_unique_id','subject_name','subject_type','reorder_no',
	  'question_mark','negative_mark','description','subject_icon','app_store_product_id',
	  'ios_subscription_type','subscription_end_date','status',
    ];
	
	protected $primaryKey='id';

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'subject_name'=>'required',
	'subject_type'=>'required',
	//'question_mark'=>'required',
	//'negative_mark'=>'required',
	'description'=>'required',
	'subject_icon'=>'required',
	'app_store_product_id'=>'required',
	'subscription_type'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_course_id'=>'required',
	'ed_subject_name'=>'required',
	'ed_description'=>'required',
	'ed_app_store_product_id'=>'required',
	'ed_subscription_type'=>'required',
	];
			
	public function addSubject($request)
	{
		
		$fname="";
		if($request->file('subject_icon'))
		{
			
			$ext=$request->file('subject_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/subject_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/subject_icons",$request->file('subject_icon'), $filename, 'public');
		}
		
		$cuid=Course::where('id',$request->course_id)->first();
				
		return self::create([
			'course_id'=>$request->course_id,
			'course_unique_id'=>$cuid->unique_id,
			'subject_name'=>$request->subject_name,
			'subject_type'=>$request->subject_type??null,
			'description'=>$request->description,
			//'question_mark'=>$request->question_mark,
			//'negative_mark'=>$request->negative_mark,
			'subscription_end_date'=>$request->subscription_end_date,
			'app_store_product_id'=>$request->app_store_product_id,
			'subject_icon'=>$fname,
			'ios_subscription_type'=>$request->subscription_type,
			'status'=>1
		]);
	}
	
	
	public function add_Subject($request) //create subject and package
	{
		
		$fname="";
		if($request->file('subject_icon'))
		{
			$ext=$request->file('subject_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/subject_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/subject_icons",$request->file('subject_icon'), $filename, 'public');
		}
		
		$cuid=Course::where('id',$request->course_id)->first();
				
		$result=self::create([
			'course_id'=>$request->course_id,
			'course_unique_id'=>$cuid->unique_id,
			'subject_name'=>$request->subject_name,
			'subject_type'=>$request->subject_type??null,
			'description'=>$request->description,
			//'question_mark'=>$request->question_mark,
			//'negative_mark'=>$request->negative_mark,
			'subscription_end_date'=>$request->subscription_end_date,
			'app_store_product_id'=>$request->app_store_product_id,
			'subject_icon'=>$fname,
			'ios_subscription_type'=>$request->subscription_type,
			'status'=>1
		]);
		
		if($result)
		{
		
		  $res=Package::create([
			'course_unique_id'=>$cuid->unique_id,
			'subject_id'=>$result->id,
			'package_name'=>$request->subject_name,
			'package_type'=>2,
			'start_date'=>$request->start_date,
			'expiry_date'=>$request->expiry_date,
			'rate'=>$request->package_rate,
			'ios_rate'=>$request->ios_rate,
			'status'=>1
			]);
		}
		
		return $result;
	}
		
	public function updateSubject($request)
	{
		
		$fname=$request->ed_sub_icon;
		
		$id=$request->ed_subject_id;
		
		if($request->file('ed_subject_icon'))
		{
			
			$dat=self::find($id);
			$fna=$dat->subject_icon;

			$ext=$request->file('ed_subject_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/subject_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/subject_icons",$request->file('ed_subject_icon'), $filename, 'public');			
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$dat=[
		'course_id'=>$request->ed_course_id,
		'subject_name'=>$request->ed_subject_name,
		'subject_type'=>$request->ed_subject_type??null,
		'description'=>$request->ed_description,
		//'question_mark'=>$request->ed_question_mark,
		//'negative_mark'=>$request->ed_negative_mark,
		'subscription_end_date'=>$request->ed_subscription_end_date,
		'app_store_product_id'=>$request->ed_app_store_product_id,
		'subject_icon'=>$fname,
		'ios_subscription_type'=>$request->ed_subscription_type,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getSubjects()
	{
		$data=self::select('subjects.*','courses.course_name')
		->leftJoin('courses','subjects.course_id','courses.id')
		->orderBy('subjects.subject_name','ASC')->get();
		return $data;
	}
	
	
	public function viewSubjects($request)   //adding subject to course
	{
		
		$search=$request->search;
			
		$dts=self::select('subjects.*')
		->where(function($where) use($search)
			    {
					$where->where('subjects.subject_name', 'like', '%' .$search . '%')
					->orWhere('subjects.unique_id', 'like', '%' .$search . '%');
			  });
		
		$dats=$dts->orderBy('subjects.id','DESC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['uid'] =$r->unique_id;
				$uData['sname'] =$r->subject_name;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
		
	public function getSubjectsByCourseId($id)
	{
		$data=self::where('course_id',$id)->orderBy('id','ASC')->get();
		return $data;
	}	
	
	public function getSubjectsByCourseUniqueId($id)
	{
		$data=self::where('course_unique_id',$id)->orderBy('id','ASC')->get();
		return $data;
	}	
	
	public function getSubjectsForReorder($id)
	{
		$data=self::where('course_unique_id',$id)->orderBy('reorder_no','ASC')->get();
		return $data;
	}	
		
	public function getSubjectById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
		
	public function deleteSubject($id)
	{
		$dat=self::find($id);
		$fna=$dat->subject_icon;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		return $result;
	}
	
	
	
	
	
	
	
	
	
}
