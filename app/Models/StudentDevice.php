<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDevice extends Model
{
    use HasFactory;
	
	protected $table='student_devices';
	
    protected $fillable = [
        'reg_date','student_id','student_name','mobile','version_release','manufacturer','model',
		'androidid','brand','device','status'
    ];

	protected $primaryKey = 'id';


    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	
	public function getStudentDevices($request)
	{
		
		$search=$request->search;
		$searchByState=$request->searchByState;
		
		//$dts=self::query();
		
		$dts=self::select('student_devices.*','students.state')
		->leftJoin('students','student_devices.student_id','=','students.id')
		->where(function($where) use($search)
			    {
					$where->where('student_devices.student_name', 'like', '%' .$search . '%')
					->orWhere('student_devices.mobile', 'like', '%' .$search . '%')
					->orWhere('student_devices.version_release', 'like', '%' .$search . '%')
					->orWhere('student_devices.model', 'like', '%' .$search . '%')
					->orWhere('student_devices.manufacturer', 'like', '%' .$search . '%')
					->orWhere('student_devices.device', 'like', '%' .$search . '%');
			  });
			  
		if($searchByState!='')
		{
			$dts->where('students.state',$searchByState);
		}
			
		$dats=$dts->orderBy('student_devices.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			$x=1;
			foreach ($dats as $r)
            {
			    $uData['sno'] = $x;
				$uData['id'] = $r->id;
				$uData['sname'] =strtoupper($r->student_name)."<br>Mob: ".$r->mobile;
				$uData['state'] =$r->state;
				$uData['version'] =$r->version_release;
				$uData['androidid'] =$r->androidid;
				$uData['manu'] =$r->manufacturer;
				$uData['device']=$r->device;
				$uData['model']=$r->model;
				
				$btn='<a href="'.url('delete_student_device').'/'.$r->id.'" id="conf" class=" btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
				$x++;
			}
        }

		return $data;
	}
	
	public function deleteStudentDevice($id)
	{
		
		$res=self::find($id)->delete();
		return $res;
	}
	
	
	
	
}
