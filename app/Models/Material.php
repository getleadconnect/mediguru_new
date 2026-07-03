<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Material extends Model
{
    use HasFactory;
	
	protected $table='materials';
	
    protected $fillable = [
      'unique_id','material_title','material_data','material_icon','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'material_title'=>'required',
	'material_data'=>'required',
	];

	
	public const EDIT_RULES=[
	'ed_material_title'=>'required',
	'ed_material_data'=>'required',
	'ed_material_icon'=>'required',
	];

	public function addMaterials($request)  
	{
		$fname="";
		if($request->file('material_icon'))
		{
			$ext=$request->file('material_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/material_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/material_icons",$request->file('material_icon'), $filename, 'public');
		}
		
		return self::create([
			'unique_id'=>$request->unique_id,
			'material_title'=>$request->material_title,
			'material_data'=>$request->material_data,
			'material_icon'=>$fname,
			'status'=>1
		]);
	}
	
		
	public function updateMaterial($request)
	{
		
		$fname=$request->ed_mat_icon;
		
		$id=$request->ed_mat_id;
		
		if($request->file('ed_material_icon'))
		{
			
			$dat=self::find($id);
			$fna=$dat->material_icon;

			$ext=$request->file('ed_material_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/material_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/material_icons",$request->file('ed_material_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$dat=[
		'unique_id'=>$request->ed_unique_id,
		'material_title'=>$request->ed_material_title,
		'material_data'=>$request->ed_material_data,
		'material_icon'=>$fname,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getClassMaterials()
	{
		$data=self::select('materials.*')->orderBy('id','ASC')->get();
		return $data;
	}
	
	
	
	public function viewMaterials($request)
	{
		
		$search=$request->search;
				
		$dts=self::select('materials.*')
			->where(function($where) use($search)
			{
				$where->where('materials.material_title', 'like', '%' .$search . '%')
					  ->orWhere('materials.unique_id', 'like', '%' .$search . '%');
				
			});
		
		$dats=$dts->orderBy('materials.id','ASC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
				if($r->status==1)
				$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
				
			    $uData['id'] = $r->id;
				$uData['uid'] = $r->unique_id;
				$uData['micon'] ='<img src="'.config('constants.file_path').$r->material_icon.'" style="width:60px">';
				$uData['mtitle'] =$r->material_title;
				$uData['mdata'] ='<a href="#" id="'.$r->id.'" data-toggle="modal" data-target="#kt-modal-1" class="btnData badge badge-primary">View</a>';
				$uData['status'] =$st;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="'.url('delete_material').'/'.$r->id.'" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				if($r->status==1)
					  $btn.='<a href="'.url('deactivate_material').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_material').'/'.$r->id.'" class="btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	

	public function getMaterialById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function deleteMaterial($id)
	{
		$dat=self::find($id);
		$fna=$dat->material_icon;
		 Storage::disk('spaces')->delete($fna);  //delete file from the disk
		$result=$dat->delete();
		return $result;
	}
	
}
