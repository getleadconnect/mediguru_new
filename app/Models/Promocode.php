<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;

	protected $table='promocodes';
	
    protected $fillable = [
      'course_id','promocode','percentage','promocode_value','expiry_date','description','user_id','discount_course','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public const RULES=[
	'course_id'=>'required',
	'promocode'=>'required',
	'percentage'=>'required',
	'expiry_date'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_course_id'=>'required',
	'ed_promocode'=>'required',
	'ed_percentage'=>'required',
	'ed_expiry_date'=>'required',
	];
		
	//fucntions

	public function addPromocode($request)
	{

		  $dt=explode("-",$request->expiry_date);
		  $edate=null;
		  if(count($dt)>1)
		  {
		    $edate=$dt[2]."-".$dt[1]."-".$dt[0];
		  }
		   $res=self::create([
			'course_id'=>$request->course_id,
			'percentage'=>$request->percentage,
			'promocode'=>$request->promocode,
			'promocode_value'=>0,
			'user_id'=>$request->user_id,
			'expiry_date'=>$edate,
			'description'=>$request->description,
			'discount_course'=>$request->discount_course,
			'status'=>1
			]);
		return $res;
	}
	
    public function updatePromocode($request)
	{

		 $dt=explode("-",$request->ed_expiry_date);
		  $edate=null;
		  if(count($dt)>1)
		  {
		    $edate=$dt[2]."-".$dt[1]."-".$dt[0];
		  }

		$id=$request->ed_promo_id;
		
		$user_id=null;
		if($request->has('ed_user_id'))
		{
			$user_id=$request->ed_user_id;
		}

		$dat=[
			'course_id'=>$request->ed_course_id,
			'promocode'=>$request->ed_promocode,
			'percentage'=>$request->ed_percentage,
			'promocode_value'=>0,
			'user_id'=>$user_id,
			'expiry_date'=>$edate,
			'description'=>$request->ed_description,
			'discount_course'=>$request->ed_discount_course,
			];
			
		$res=self::where('id',$id)->update($dat);
		
		return $res;
	}

	public function viewPromocodes($crsid)
	{
		
		$dts=self::select('promocodes.*','courses.course_name')
		->leftJoin('courses','promocodes.course_id','=','courses.id')
		->orderBy('promocodes.id','DESC')->get();
		
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
					$st="<span class='kt-badge kt-badge--danger kt-badge--inline kt-badge--pill'>Inactive</span>";
				}

				$dcourse="--";
				if($r->discount_course!="")
				{
					$dcourse=Course::where('id',$r->discount_course)->pluck('course_name');
				}

								
			    $uData['id'] = $r->id;
				$uData['cname']=$r->course_name;
				$uData['pcode']=$r->promocode;
				$uData['dcrs']=$dcourse;
				$uData['pvalue']=($r->percentage??"0")."%";
				$uData['usr']=$r->user_id??"--";
				$uData['expdate']=date_create($r->expiry_date)->format('d-m-Y');
				$uData['desc']=$r->description;
				$uData['status']=$st;

				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon"  data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" class="btndel btn btn-danger btn-elevate btn-circle btn-icon"  title="Delete"><i class="fa fa-trash"></i></a>'; 
					 //<a href="'.url('delete_promocode').'/'.$r->id.'" id="conf" class="edit btn btn-danger btn-elevate btn-circle btn-icon"  title="Delete"><i class="fa fa-trash"></i></a>'; 
					 
				if($r->status==1)
					  $btn.='<a href="#" id="'.$r->id.'/1" class="btnActDeact btn btn-warning btn-elevate btn-circle btn-icon"  title="Deactivate" style="margin-left:3px;"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="#" id="'.$r->id.'/2" class="btnActDeact btn btn-success btn-elevate btn-circle btn-icon"  title="Activate" style="margin-left:3px;"><i class="fa fa-check"></i></a>'; 	
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function getPromocodes()
	{
		$data=self::select('promocode')->orderBy('id','ASC')->get();
		return $data;
	}
		

	public function getPromocodeByCourseId($crsid)
	{
		$data=self::where('course_id',$crsid)->whereNull('user_id')->get();
		return $data;
	}

	
	public function getPromocodeAmount($code)
	{
		$data=self::where('promocode',$code)->get()->first();
		return $data;
	}
	
	public function getPromocodeById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deletePromocode($id)
	{
		$result=self::find($id)->delete();

		return $result;
	}
	
	
}
