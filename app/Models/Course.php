<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Course extends Model
{
    use HasFactory;
	
	protected $table='courses';
	
    protected $fillable = [
      'unique_id','course_name','course_type','description','features','course_icon',
	  'subscription_end_date','app_store_product_id','ios_subscription_type','reorder_no','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'unique_id'=>'required',
	'course_name'=>'required',
	'description'=>'required',
	'course_icon'=>'required',
	'features'=>'required',
	'subscription_type'=>'required',
	];
	
	
	public const EDIT_RULES=[
	'ed_unique_id'=>'required',
	'ed_course_name'=>'required',
	'ed_description'=>'required',
	'ed_features'=>'required',
	'ed_subscription_type'=>'required',
	];
		
	public function addCourse($request)
	{
		
		$fname="";
		if($request->file('course_icon'))
		{
			
			$ext=$request->file('course_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/course_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/course_icons",$request->file('course_icon'), $filename, 'public');
	
		}
		
		$course_type=0;
		if( $request->has('course_type')){	$course_type=1;}
		
		return self::create([
		'unique_id'=>$request->unique_id,
		'course_name'=>$request->course_name,
		'course_type'=>$course_type,
		'description'=>$request->description,
		'features'=>$request->features,
		'subscription_end_date'=>$request->subscription_end_date,
		'app_store_product_id'=>$request->app_product_id,
		'course_icon'=>$fname,
		'ios_subscription_type'=>$request->subscription_type,
		'reorder_no'=>$request->reorder_no,
		'status'=>1
		]);
		
	}
		
	public function updateCourse($request)
	{
		
		$fname=$request->ed_crs_icon;
		
		$id=$request->ed_course_id;
		
		if($request->file('ed_course_icon'))
		{
			
			$dat=self::find($id);
			$fna=$dat->course_icon;
						
			$ext=$request->file('ed_course_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/course_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/course_icons",$request->file('ed_course_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk

		}
		
		$course_type=0;
		if( $request->has('ed_course_type')){ $course_type=1; }
		
		$dat=[
		'unique_id'=>$request->ed_unique_id,
		'course_name'=>$request->ed_course_name,
		'course_type'=>$course_type,
		'description'=>$request->ed_description,
		'features'=>$request->ed_features,
		'subscription_end_date'=>$request->ed_subscription_end_date,
		'app_store_product_id'=>$request->ed_app_product_id,
		'course_icon'=>$fname,
		'ios_subscription_type'=>$request->ed_subscription_type,
		'reorder_no'=>$request->ed_reorder_no,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getCourses()
	{
		$data=self::orderBy('reorder_no','ASC')->get();
		return $data;
	}
	
	public function getHiddenCourses()
	{
		$data=self::where('course_type',1)->orderBy('id','ASC')->get();
		return $data;
	}
	
	
	public function getCourseById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteCourse($id)
	{
		$dat=self::find($id);
		$fna=$dat->course_icon;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		return $result;
	}
	
	
}
