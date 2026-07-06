<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Material;

class LessonMaterial extends Model
{
    use HasFactory;
	
	protected $table='lesson_materials';
	
    protected $fillable = [
      'subject_id','lesson_id','material_unique_id','order_no'
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public function addLessonMaterial($request)  
	{
		return self::create([
			'subject_id'=>$request->subject_id,
			'lesson_id'=>$request->lesson_id,
			'material_unique_id'=>$request->unique_id,
		]);
	}
	
	public function viewAllLessonMaterials($request)
	{
		
		$search=$request->search;
		$lesid=$request->searchByLesson;
		
		$dts=self::select('lesson_materials.*','materials.material_title','materials.material_icon','materials.material_data','subjects.subject_name','lessons.lesson_name')
		->leftJoin('materials','lesson_materials.material_unique_id','=','materials.unique_id')
		->leftJoin('lessons','lesson_materials.lesson_id','=','lessons.id')
		->leftJoin('subjects','lesson_materials.subject_id','=','subjects.id')
		->where(function($where) use($search)
			    {
					$where->where('materials.material_title', 'like', '%' .$search . '%')
					->where('lessons.lesson_name', 'like', '%' .$search . '%');
			  });

		if($lesid!="" )
		{
			$dts->where('lesson_materials.lesson_id',$lesid);
		}

		$dats=$dts->orderBy('materials.id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['uid'] =$r->material_unique_id;
				$uData['micon'] ='<img src="'.config('constants.file_path').$r->matertial_icon.'" style="width:50px;">';
				$uData['title'] =$r->material_title;
				$uData['sname'] =$r->subject_name;
				$uData['lname'] =$r->lesson_name;
				$uData['dat'] ='<a href="#" class="view badge badge-warning" id="'.$r->material_unique_id.'" data-toggle="modal" data-target="#kt_modal_1">View</a>';
				
				if($r->status==1)
					$st='<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">Active</span>';
				else
					$st='<span class=" kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
				$uData['status'] =$st;
				
				$btn='<a href="#" id="'.$r->id.'" class=" btnDel btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
		
	
	public function viewMaterials($request)
	{
		
		$search=$request->search;
		$crsid=$request->searchByCourse;
				
		$dts=Material::select('materials.*')
		->where(function($where) use($search)
			    {
					$where->where('materials.material_title', 'like', '%' .$search . '%')
					->orWhere('materials.unique_id', 'like', '%' .$search . '%');
			  });

		$dats=$dts->orderBy('materials.id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['uid'] =$r->unique_id;
				$uData['vicon'] ='<img src="'.config('constants.file_path').$r->matertial_icon.'" style="width:50px;">';
				$uData['title'] =$r->material_title;
				
				//$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					// <a href="#" id="'.$r->id.'" class=" btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				//$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
		
		
	public function LessonMaterials($request)  //get lesson items
	{
		$search=$request->search;
		$lesid=$request->searchByLesson;
		
		$dats=self::select('lesson_materials.*','materials.material_title','materials.material_icon')
		->leftJoin('materials','lesson_materials.material_unique_id','=','materials.unique_id')
		->where('lesson_materials.lesson_id',$lesid)
		->where(function($where) use($search)
			  {
				$where->where('materials.material_title', 'like', '%' .$search . '%')
				->orWhere('lesson_materials.material_unique_id', 'like', '%' .$search . '%');
			  })->orderBy('lesson_materials.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
			    $uData['id'] = ++$key;
				$uData['icon'] ='<img src="'.config('constants.file_path').$r->material_icon.'" style="width:50px;">';
				$uData['dat'] ="<span style='font-size:12px;'>Uid : ".$r->material_unique_id."</b><br>Title : ".$r->material_title."</span>";
				
				if($r->order_no!="")
				{		
					$ordn=$r->order_no;
					$ordn.='&nbsp;<a href="#" id="'.$r->id.'" class="btnOrder btn bt-brand btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal" data-target="#kt_modal_3" style="width:1.75rem;height:1.75rem;" title="Add/Change"><i class="fa fa-edit" style="color:#637ddb;"></i></a>';
				}
				else
				{
					$ordn='<a href="#" id="'.$r->id.'" class="btnOrder btn bt-brand btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal" data-target="#kt_modal_3" style="width:1.75rem;height:1.75rem;" title="Add/Change"><i class="fa fa-edit" style="color:#637ddb;"></i></a>';
				}
				
				$uData['ord'] =$ordn;

				$uData['action'] ='<a href="#" id="'.$r->id.'" class="btnDel btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" style="width:1.75rem;height:1.75rem;" title="Delete"><i class="fa fa-trash"></i></a>';
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	
	
	public function getLessonMaterials()
	{
		$data=self::select('lesson_materials.*')->orderBy('id','ASC')->get();
		return $data;
	}
	
		
	public function getLessonMaterialById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function deleteLessonMaterial($id)
	{
		$dat=self::find($id);
		$result='';
		if(!empty($dat))
		{
		  $result=$dat->delete();
		}
		return $result;
	}
		
	
	
}
