<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagePayment extends Model
{
    use HasFactory;
	
	protected $table='package_payments';
	
    protected $fillable = [
      'student_id','package_id','course_unique_id','payment_id','promocode','promocode_value','referral_code','referral_value',
	  'package_rate','net_amount','status',
    ];

	protected $primaryKey='id';
	
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public function addPayment($request)
	{
			   
		  $result=self::create([
			'student_id'=>$request->student_id,
			'course_unique_id'=>$request->course_unique_id,
			'package_id'=>$request->package_id,
			'promocode'=>$request->promocode,
			'promocode_amount'=>$request->promocode_value,
			'referral_code'=>$request->referral_code,
			'referral_amount'=>$request->referral_value,
			'amount'=>$request->package_rate,
			'net_amount'=>$request->net_amount,
			'state'=>$request->state,
			'status'=>1
			]);
	
		return $result;
    }
	

	public function getPayments($request)
	{

		$search=$request->search;
		$course=$request->flt_course;
		$year=$request->flt_year;
		$drange=explode('-',$request->dateRange);
		
		$dt1="";$dt2="";
		
		if(count($drange)>1)
		{
		$dt1=date_create($drange[0])->format('Y-m-d');
		$dt2=date_create($drange[1])->format('Y-m-d');
		}

		
		$dts=self::query();
		
		$dts->select('package_payments.*','students.name','students.mobile','courses.course_name')
		->leftJoin('students','package_payments.student_id','=','students.id')
		//->leftJoin('packages','package_payments.package_id','=','packages.id')
		->leftJoin('courses','package_payments.course_unique_id','=','courses.unique_id')
		->where(function($where) use($search)
			{
				$where->where('students.name', 'like', '%' .$search . '%')
				->orWhere('students.mobile', 'like', '%' .$search . '%')
				->orWhere('courses.course_name', 'like', '%' .$search . '%')
				->orWhere('package_payments.package_rate', 'like', '%' .$search . '%')
				->orWhere('package_payments.net_amount', 'like', '%' .$search . '%');
			});
		
		if($course!="" and $year!="")
		{
			$dts->where('package_payments.course_unique_id',$course)->whereYear('package_payments.created_at',$year);
		}
		else if($course==""  and $year!="")
		{
			$dts->whereYear('package_payments.created_at',$year);
		}
		else if($dt1!="" and $dt2!="")
		{
			$dts->whereBetween('package_payments.created_at',[$dt1,$dt2]);
		}
		
		$dats=$dts->orderBy('package_payments.id','ASC')->get();
		
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
				$pkg_na='';
				if(strpos($r->package_id,',')!=false)
				{
					$pkid=explode(",",$r->package_id);
					
					$pna=Package::whereIn('id',$pkid)->get();
					foreach($pna as $r1)
					{
						$pkg_na.=",●-".$r1->package_name;
					}
					
					$pkg_na=substr($pkg_na,1);
				}
				else
				{
					$pna=Package::where('id',$r->package_id)->first();
					$pkg_na=(!empty($pna))?$pna->package_name:'';
				}
    			
			    $uData['id'] = $r->id;
				$uData['date'] =date_create($r->created_at)->format('d-m-Y');
				$uData['name'] =strtoupper($r->name)."<br>Mob: ".$r->mobile;
				$uData['course'] =$r->course_name;
				$uData['package'] =$pkg_na;
				$uData['prate'] =$r->package_rate;
				$uData['pvalue'] =$r->promocode_value;
				$uData['rvalue'] =$r->referral_value;
				$uData['prate'] =$r->package_rate;
				$uData['netamt'] =$r->net_amount;
				
				$btn='<a href="'.url('delete_payment').'/'.$r->id.'" id="conf" class=" btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
				/*if($r->status==1)
					  $btn.='<a href="'.url('deactivate_student').'/'.$r->id.'" class="btn btn-warning shadow btn-xs sharp mr-1" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_student').'/'.$r->id.'" class="btn btn-success shadow btn-xs sharp mr-1" title="Activate"><i class="fa fa-check"></i></a>'; 	
				 */
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	public function deletePayment($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}
	
	
}
