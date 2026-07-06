<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use DB;
use Log;
use Session;
use Carbon\Carbon;

class Student extends Model
{
    use HasFactory;
	
	protected $table='students';
	
    protected $fillable = [
      'reg_date','name','gender','date_of_birth','mobile','email','state','student_image','package_status','status',
    ];

	protected $primaryKey='id';
	
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'name'=>'required',
	'gender'=>'required',
	'birthdate'=>'required',
	'mobile'=>'required',
	'email'=>'required',
	'password'=>'required',
	'package_id'=>'required',
	'package_rate'=>'required',
	'net_amount'=>'required'
	];

	public function addStudent($request)
	{
					
		$fname="";
		if($request->file('student_image'))
		{
			
			$ext=$request->file('student_image')->getClientOriginalExtension();	 
			$filename = "st_".date('Ymdhis').".".$ext;
			$fname ="mediguru/student_images/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/student_images",$request->file('student_image'), $filename, 'public');

			//$icon->move(public_path('uploads/course_icons'), $fname);
			//Storage::disk('s3')->put($fname, file_get_contents($request->file('dv_file')),'public');
		}
	
		$result="";
		
		DB::beginTransaction();
        try{
               
			$stud=self::create([
				'reg_date'=>date('Y-m-d'),
				'name'=>$request->name,
				'gender'=>$request->gender,
				'date_of_birth'=>$request->birthdate,
				'mobile'=>$request->mobile,
				'email'=>$request->email,
				'state'=>$request->state,
				'student_image'=>$fname,
				'status'=>1
				]);
			
			$res=User::create([
				'student_id'=>$stud->id,
				'mobile'=>$request->mobile,
				'email'=>$request->email,
				'password'=>Hash::make($request->password),
				'status'=>1
			]);
			
			 $currentDateTime = Carbon::now();
			 
			 if($request->subscription_plan_type==1)
			 {
				$endDateTime = Carbon::now()->addYear();
			 }
			 else if($request->subscription_plan_type==6)
			 {
				$endDateTime = Carbon::now()->addMonths(6);
			 }
			 else 
			 {
				$endDateTime = Carbon::now()->addMonths(3);
			 }
			 
						
			$result=PurchasedPackage::create([
				'student_id'=>$stud->id,
				'course_unique_id'=>$request->course_id,
				'package_id'=>$request->package_id,
				'package_type'=>$request->package_type,
				'promocode'=>$request->promocode,
				'promocode_amount'=>$request->promocode_amount,
				'referral_code'=>$request->referral_code,
				'referral_amount'=>$request->referral_amount,
				'amount'=>$request->package_rate,
				'net_amount'=>$request->net_amount,
				'subscription_start_date'=>date_create($currentDateTime)->format('Y-m-d'),
				'subscription_end_date'=>date_create($endDateTime)->format('Y-m-d'),
				'status'=>1
			]);
			
			if($result)
			{
				$new=['package_status'=>1];
				$res2=self::where('id',$stud->id)->update($new);
			}

           DB::commit();
		}
		catch(\Exception $e)
		{
			\Log::info($e->getMessage());
			//\Log::info($e);
			 DB::rollback();
		}
			
	return $result;
}

		
	public function updateStudent($request)
	{
		
		$fname=$request->stud_image;
		
		$id=$request->stud_id;
		
		if($request->file('stud_image'))
		{
			
			$dat=self::find($id);
			$fna=$dat->student_image;

			$ext=$request->file('stud_image')->getClientOriginalExtension();	 
			$filename = "st_".date('Ymdhis').".".$ext;
			$fname ="mediguru/student_images/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/student_images",$request->file('stud_image'), $filename, 'public');
		
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$result="";
		DB::beginTransaction();
        try{
		
		$dat=[
			'name'=>$request->name,
			'gender'=>$request->gender,
			'date_of_birth'=>$request->birthdate,
			'mobile'=>$request->mobile,
			'email'=>$request->email,
			'state'=>$request->state,
			'student_image'=>$fname,
			'status'=>1
		];

		$dat1=[
			'mobile'=>$request->mobile,
			'email'=>$request->email,
		];
			
		
		$result=self::whereId($id)->update($dat);
		$res=User::where('student_id',$id)->update($dat1);
        DB::commit();
		}
		catch(\Exception $e)
		{
			//\Log::info($e);
			 DB::rollback();
		}
		
		return $result;
	}
		
	
	public function getStudentById($id)
	{
		$data=self::select('students.*')
		->where('students.id',$id)->first();
		return $data;
	}
	
	public function getStudentsByCourseUniqueId($uid)
	{
		$data=self::select('students.*')
		->leftJoin('purchased_packages','students.id','=','purchased_packages.student_id')
		->where('purchased_packages.course_unique_id',$uid)->get();
		return $data;
	}
	
		
  public function getStudents($request)
	{
		
		$search=$request->search;
				
		$dts=self::select('students.*')
		//->leftJoin('courses','question_papers.course_id','=','courses.id')
		->where(function($where) use($search)
			    {
					$where->where('students.name', 'like', '%' .$search . '%')
					->orWhere('students.gender', 'like', '%' .$search . '%')
					->orWhere('students.mobile', 'like', '%' .$search . '%')
					->orWhere('students.email', 'like', '%' .$search . '%')
					->orWhere('students.state', 'like', '%' .$search . '%');
			  })->orderBy('students.id','DESC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
				if($r->status==1)
				$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
				
			    $uData['id'] = $r->id;
				$uData['simage'] ='<img src="'.config('constants.file_path').$r->student_image.'" style="width:60px">';
				$uData['name'] =strtoupper($r->name)."<br>Mob: ".$r->mobile."<br>Email: ".$r->email;
				$uData['gender'] =$r->gender."<br>Dob:".$r->date_of_birth;
				$uData['state']=$r->state;
				$uData['cdate']=date_create($r->created_at)->format('d-m-Y h:i:s A');
				$uData['status'] =$st;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn bt-brand btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="'.url('delete_student').'/'.$r->id.'" id="conf" class="btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				/*if($r->status==1)
					  $btn.='<a href="'.url('deactivate_student').'/'.$r->id.'" class="btn btn-warning shadow btn-xs sharp mr-1" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_student').'/'.$r->id.'" class="btn btn-success shadow btn-xs sharp mr-1" title="Activate"><i class="fa fa-check"></i></a>'; 	
				*/
				 $pkg_status="";
				 if($r->package_status==1)
				 {
					$pkg_status='&nbsp;<span class="kt-badge kt-badge--outline kt-badge--success" title="Package purchased">✓</span>';	 
				 }
				 
				$uData['pkg'] = '<a href="#" id="'.$r->id.'" class="addPkg btn btn-primary btn-xs" data-toggle="modal" style="padding:3px 7px; font-size:12px;"  title="Add Package"><i class="fa fa-plus"></i>Add</a>';
				$uData['pkg'] .=$pkg_status;
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	public function deleteStudent($id)
	{
		$dat=self::find($id);
		$result="";

		$res1=User::where('student_id',$id)->delete();
		$res2=PurchasedPackage::where('student_id',$id)->delete();
			
		if(!empty($dat))
		{
			$fna=$dat->student_image;
			$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}

		return $result;
	}
	
//-----------------------------ADD NEW PACKAGE TO STDUENT-------------------------------------------------------------------	
	
	public function addPackage($request)
	{
		$result="";
		
		DB::beginTransaction();
        try{
			
			$stid=$request->stud_id;
			
			$currentDateTime = Carbon::now();
			 
			 if($request->subscription_plan_type==1)
			 {
				$endDateTime = Carbon::now()->addYear();
			 }
			 else if($request->subscription_plan_type==6)
			 {
				$endDateTime = Carbon::now()->addMonths(6);
			 }
			 else 
			 {
				$endDateTime = Carbon::now()->addMonths(3);
			 }
			
			$result=PurchasedPackage::create([
				'student_id'=>$stid,
				'course_unique_id'=>$request->course_id,
				'package_id'=>$request->package_id,
				'package_type'=>$request->package_type,
				'promocode'=>$request->promocode,
				'promocode_amount'=>$request->promocode_amount,
				'referral_code'=>$request->referral_code,
				'referral_amount'=>$request->referral_amount,
				'amount'=>$request->package_rate,
				'net_amount'=>$request->net_amount,
				'subscription_start_date'=>date_create($currentDateTime)->format('Y-m-d'),
				'subscription_end_date'=>date_create($endDateTime)->format('Y-m-d'),
				'status'=>1
			]);
			
			if($result)
			{
				$new=['package_status'=>1];
				$res1=self::where('id',$stid)->update($new);
			}
			
           DB::commit();
		}
		catch(\Exception $e)
		{
			 DB::rollback();
		}
			
	return $result;
}
	
	
	
	
}
