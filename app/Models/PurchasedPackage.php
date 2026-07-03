<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasedPackage extends Model
{
    use HasFactory;
	
	protected $table='purchased_packages';
	
    protected $fillable = [
      'course_unique_id','student_id','package_id','package_type','promocode','promocode_amount','referral_code','referral_amount',
	  'amount','net_amount','subscription_start_date','subscription_end_date','status',
    ];

	protected $primaryKey='id';
	
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	

public function purchasePackage($request)
	{

		$result="";
		    DB::beginTransaction();
            try{
               
			  //$namt=$request->package_rate - ($request->promocode_amount+$request->referral_amount);  
			   
			  $result=self::create([
				'student_id'=>$request->student_id,
				'course_unique_id'=>$request->course_unique_id,
				'package_id'=>$request->package_id,
				'promocode'=>$request->promocode,
				'promocode_amount'=>$request->promocode_amount,
				'referral_code'=>$request->referral_code,
				'referral_amount'=>$request->referral_amount,
				'amount'=>$request->package_rate,
				'net_amount'=>$request->net_amount,
				'state'=>$request->state,
				'status'=>1
				]);

            DB::commit();
			}
			catch(\Exception $e)
			{
				DB::rollback();
			}
			
		return $result;
    }
	
	public function deletePurchasedPackageById($id)
	{
			
		$res=self::find($id);
		$result=false;
		if(!empty($res))
		{
			$stid=$res->student_id;
			$pcnt=self::where('student_id',$stid)->count();
			
			$result=$res->delete();
			
			if($pcnt<=0)
			{
				$new=['package_status'=>0];
				$res1=Student::where('id',$stid)->update($new);
			}
		}			
		
		return $result;
	}
	
	public function deletePurchasedPackageByStudentId($stid)
	{
		$result=self::where('student_id',$stid)->delete();
		return $result;
	}
	
	
}

