<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

	protected $table='staffs';
	
    protected $fillable = [
      'staff_name','gender','email','mobile','referral_code','referral_value','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public const RULES=[
	'staff_name'=>'required',
	'gender'=>'required',
	'email'=>'required',
	'mobile'=>'required',
	'referral_code'=>'required',
	'referral_value'=>'required',
	];
	
	
	//fucntions

	public function addStaff($request)
	{

		   $res=self::create([
			'staff_name'=>$request->staff_name,
			'gender'=>$request->gender,
			'email'=>$request->email,
			'mobile'=>$request->mobile,
			'referral_code'=>$request->referral_code,
			'referral_value'=>$request->referral_value,
			'status'=>1
			]);
		return $res;
	}
	
    public function updateStaff($request)
	{

		$id=$request->staff_id;
		$dat=[
			'staff_name'=>$request->staff_name,
			'gender'=>$request->gender,
			'email'=>$request->email,
			'mobile'=>$request->mobile,
			'referral_code'=>$request->referral_code,
			'referral_value'=>$request->referral_value,
			'status'=>1
			];
		$res=self::where('id',$id)->update($dat);
		
		return $res;
	}

	public function getStaffs()
	{
		
		$dts=self::select('staffs.*')->orderBy('staffs.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
				if($r->status==1)
				{
					$st="<span class='kt-badge kt-badge--success  kt-badge--inline kt-badge--pill'>Active</span>";
				}	
				else 
				{
					$st="<span class='kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill'>Inactive</span>";
				}
								
			    $uData['id'] = $r->id;
				$uData['sname']=$r->staff_name;
				$uData['gender']=$r->gender;
				$uData['email']=$r->email;
				$uData['mobile']=$r->mobile;
				$uData['rcode']=$r->referral_code;
				$uData['rvalue']=$r->referral_value;
				$uData['status']=$st;

				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon"  data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="'.url('delete_staff').'/'.$r->id.'" id="conf" class="edit btn btn-danger btn-elevate btn-circle btn-icon"  title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				if($r->status==1)
					  $btn.='<a href="'.url('deactivate_staff').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon"  title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_staff').'/'.$r->id.'" class="btn btn-success btn-elevate btn-circle btn-icon"  title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
		
	
	public function getReferralCodes()
	{
		$data=self::select('referral_code')->orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getReferralCodeAmount($code)
	{
		$data=self::where('referral_code',$code)->get()->first();
		return $data;
	}
	
	public function getStaffById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteStaff($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}
	
	
}
