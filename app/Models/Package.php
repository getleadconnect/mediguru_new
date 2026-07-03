<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Course;
use App\Models\Subject;
use Log;

class Package extends Model
{
    use HasFactory;
	
	protected $table='packages';
	
    protected $fillable = [
      'course_unique_id','subject_id','package_name','package_type','start_date','expiry_date',
	  'rate','rate_6_months','rate_3_months','ios_rate','ios_6_months','ios_3_months','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
			
			
	public const RULES=[
	'course_id'=>'required',
	'start_date'=>'required',
	'expiry_date'=>'required',
	'package_rate'=>'required',
	'ios_rate'=>'required',
	];
	
	
	public const EDIT_RULES=[
	'ed_package_name'=>'required',
	//'ed_start_date'=>'required',
	//'ed_expiry_date'=>'required',
	'ed_package_rate'=>'required',
	'ed_ios_rate'=>'required',
	'ed_ios_6_months'=>'required',
	'ed_ios_3_months'=>'required',
	'ed_rate_6_months'=>'required',
	'ed_rate_3_months'=>'required',
	
	];
	
	//fucntions

  public function addPackage($request)  //subject package
	{
		$cuid="";
		$crs=Course::select('unique_id')->where('id',$request->course_id)->first();
		if(!empty($crs)){$cuid=$crs->unique_id;}else {$cuid=null;}

			$sub=Subject::where('id',$request->subject_id)->first();
			
			$sname='';
			if(!empty($sub))
			{
			    $sname=$sub->subject_name;
			}
		
	    $res=self::create([
			'course_unique_id'=>$cuid,
			'subject_id'=>$request->subject_id,
			'package_name'=>$sname,
			'package_type'=>2,
			'start_date'=>$request->start_date,
			'expiry_date'=>$request->expiry_date,
			'rate'=>$request->package_rate,
			'rate_6_months'=>$request->rate_6_months,
			'rate_3_months'=>$request->rate_3_months,
			'ios_rate'=>$request->ios_rate,
			'ios_6_months'=>$request->ios_6_months,
			'ios_3_months'=>$request->ios_3_months,
			'status'=>1
			]);

		return $res;
	}
	
	
		//fucntions

  public function addCoursePackage($request)
	{
		$cuid="";
		$crs=Course::select('unique_id')->where('id',$request->course_id)->first();
		if(!empty($crs)){$cuid=$crs->unique_id;}else {$cuid=null;}
		
		$subj=Subject::where('course_id',$request->course_id)->get();
		
		$sub='';
		foreach($subj as $r)
		{
			$sub.=",".$r->id;
		}
		$sub=substr($sub,1);

	    $res=self::create([
			'course_unique_id'=>$cuid??null,
			'subject_id'=>$sub,
			'package_name'=>$request->package_name,
			'package_type'=>1,
			'start_date'=>$request->start_date,
			'expiry_date'=>$request->expiry_date,
			'rate'=>$request->package_rate,
			'rate_6_months'=>$request->rate_6_months,
			'rate_3_months'=>$request->rate_3_months,
			'ios_rate'=>$request->ios_rate,
			'ios_6_months'=>$request->ios_6_months,
			'ios_3_months'=>$request->ios_3_months,
			'status'=>1
			]);

		return $res;
	}
		
  public function updatePackage($request)
	{
				
		$id=$request->ed_pkgid;
		
		$dat=[
		'course_unique_id'=>$request->ed_course_id,
		'subject_id'=>$request->ed_subject_id,
		'package_name'=>$request->ed_package_name,
		//'start_date'=>$request->ed_start_date,
		//'expiry_date'=>$request->ed_expiry_date,
		'rate'=>$request->ed_package_rate,
		'rate_6_months'=>$request->ed_rate_6_months,
		'rate_3_months'=>$request->ed_rate_3_months,
		'ios_rate'=>$request->ed_ios_rate,
		'ios_6_months'=>$request->ed_ios_6_months,
		'ios_3_months'=>$request->ed_ios_3_months,
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

public function updateCoursePackage($request)
	{
				
		$id=$request->ed_pkgid;
		
		$dat=[
		'course_unique_id'=>$request->ed_course_id,
		'package_name'=>$request->ed_package_name,
		'start_date'=>$request->ed_start_date,
		'expiry_date'=>$request->ed_expiry_date,
		'rate'=>$request->ed_package_rate,
		'rate_6_months'=>$request->ed_rate_6_months,
		'rate_3_months'=>$request->ed_rate_3_months,
		'ios_rate'=>$request->ed_ios_rate,
		'ios_6_months'=>$request->ed_ios_6_months,
		'ios_3_months'=>$request->ed_ios_3_months,
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}


   public function viewSubjectPackages($request)
	{
		
		$search=$request->search;
		
		$dts=self::select('packages.*','courses.course_name','subjects.subject_name')
		->leftJoin('courses','packages.course_unique_id','=','courses.unique_id')
		->leftJoin('subjects','packages.subject_id','=','subjects.id')
		->where('packages.package_type',2)
		->where(function($where) use($search)
			    {
					$where->where('packages.package_name', 'like', '%' .$search . '%')
					->orWhere('packages.start_date', 'like', '%' .$search . '%')
					->orWhere('packages.expiry_date', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('subjects.subject_name', 'like', '%' .$search . '%');
			  })->orderBy('packages.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
				$btn="";
				
				if($r->status==1)
				   $st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else 
				   $st='<span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill">Inactive</span>';
				
				if($r->expiry_date<date('Y-m-d'))
				{
					$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Expired</span>';
				}
			
											
			    $uData['id'] = $r->id;
				//$uData['cname']=$r->course_name;
				//$uData['sname']=$r->subject_name;

					$uData['cname']=strtoupper($r->course_name);
					$uData['subname']=$r->subject_name;
					$uData['pname']=$r->package_name;

				$uData['period']=date_create($r->start_date)->format('d-m-Y')."<span style='color:red;font-weight:600;'>&nbsp;=>&nbsp;</span>".date_create($r->expiry_date)->format('d-m-Y');
				
				$uData['rate']="1 Year ₹ ".$r->rate."<br>6-Months: ₹ ".$r->rate_6_months."<br>3-Months: ₹ ".$r->rate_3_months;
				$uData['ios_rate']="1 year: ₹ ".$r->ios_rate."<br>6-Months: ₹ ".$r->ios_6_months."<br>3-Months: ₹ ".$r->ios_3_months;

				$uData['status']=$st;
				
				$btn.='<a href="#" id="'.$r->id.'" class="edit btn btn-primary btn-elevate btn-circle btn-icon" data-toggle="modal" title="Delete"><i class="fa fa-edit"></i></a>&nbsp;
				<a href="'.url('delete_subject_package').'/'.$r->id.'/1" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				if($r->status==1)
					  $btn.='<a href="'.url('deactivate_package').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_package').'/'.$r->id.'" class=" btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				$uData['action']=$btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	
	 public function viewCoursePackages($request)
	{
		
		$search=$request->search;
		
		$dts=self::select('packages.*','courses.course_name','subjects.subject_name')
		->leftJoin('courses','packages.course_unique_id','=','courses.unique_id')
		->leftJoin('subjects','packages.subject_id','=','subjects.id')
		->where('package_type',1)
		->where(function($where) use($search)
			    {
					$where->where('packages.package_name', 'like', '%' .$search . '%')
					->orWhere('packages.start_date', 'like', '%' .$search . '%')
					->orWhere('packages.expiry_date', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('subjects.subject_name', 'like', '%' .$search . '%');
			  })->orderBy('packages.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
				//--- suject names------------------------
				$subs=explode(',',$r->subject_id);
				$subna="";
				foreach($subs as $s)
				{
					$sna=Subject::where('id',$s)->first();
					if(!empty($sna)) {	$subna.=" ●".$sna->subject_name;	}else{	$subna.="";	}
				}
				//------------------------------------------
				
				$btn="";
				
				if($r->status==1)
				   $st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else 
				   $st='<span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill">Inactive</span>';
				
				if($r->expiry_date<date('Y-m-d'))
				{
					$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Expired</span>';
				}
			
											
			    $uData['id'] = $r->id;
				//$uData['cname']=$r->course_name;
				//$uData['sname']=$r->subject_name;
	
				$uData['cname']=strtoupper($r->course_name);
				$uData['pname']=$r->package_name;
				$uData['subname']=$subna;
	
				$uData['period']=date_create($r->start_date)->format('d-m-Y')."<span style='color:red;font-weight:600;'>&nbsp;=>&nbsp;</span>".date_create($r->expiry_date)->format('d-m-Y');
				$uData['rate']="1 Year ₹ ".$r->rate."<br>6-Months: ₹ ".$r->rate_6_months."<br>3-Months: ₹ ".$r->rate_3_months;
				$uData['ios_rate']="1 year: ₹ ".$r->ios_rate."<br>6-Months: ₹ ".$r->ios_6_months."<br>3-Months: ₹ ".$r->ios_3_months;
				$uData['status']=$st;
				
				$btn.='<a href="#" id="'.$r->id.'" class="edit btn btn-primary btn-elevate btn-circle btn-icon" data-toggle="modal" title="Delete"><i class="fa fa-edit"></i></a>&nbsp;
				<a href="'.url('delete_package').'/'.$r->id.'/2" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				if($r->status==1)
				{
					  $btn.='<a href="'.url('deactivate_package').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				}
				else
				{
					 $btn.='<a href="'.url('activate_package').'/'.$r->id.'" class=" btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				}
				
				$btn1='&nbsp;&nbsp;<a href="#" id="'.$r->id.'" res="'.$r->course_unique_id.'" class="btnADsub btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal" data-target="#kt_modal_2" title="add/Delete subjects"><span style="font-size:23px;">±</span></a>&nbsp;';
				
				$uData['action']=$btn.$btn1;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

		
	//-------------------------------------------------------------------------------------------------
	
		
	public function getPackagesByCourseUniqueId($crsid)   //use unique_id
	{
		$data=Package::where('course_unique_id',$crsid)->orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getSinglePackages()
	{
		
		$data=Package::orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getAllPackages()
	{
		
		$data=Package::orderBy('id','ASC')->get();
		return $data;
	}
		
		
	public function getPackageById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deletePackage($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}
	
	
}
