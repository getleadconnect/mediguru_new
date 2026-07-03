<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MaterialComment extends Model
{
    use HasFactory;
	
	protected $table='material_comments';
	
    protected $fillable = [
      'student_id','video_unique_id','material_type','comments',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		

	public function addMaterialComment($request)  
	{

		return self::create([
			'student_id'=>$request->student_id,
			'video_unique_id'=>$request->video_unique_id,
			'material_type'=>$request->material_type,
			'comments'=>$request->comment,
		]);
	}
	
	
	public function viewMaterialComments($request)
	{
		
		$search=$request->search;
		$mtype=$request->searchMType;
			
		$dts=self::select('material_comments.*','students.name','videos.title')
		->leftJoin('students','material_comments.student_id','=','students.id')
		->leftJoin('videos','material_comments.video_unique_id','=','videos.unique_id')
		->where(function($where) use($search)
			{
				$where->where('material_comments.video_unique_id', 'like', '%' .$search . '%')
				->orWhere('material_comments.material_type', 'like', '%' .$search . '%')
				->orWhere('videos.title', 'like', '%' .$search . '%')
				->orWhere('students.name', 'like', '%' .$search . '%');
			});
		
			if($mtype!='')
			{
				$dts->where('material_type',$mtype);
			}
		
		$dats=$dts->orderBy('material_comments.id','ASC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$mt='';
			
				if($r->material_type==1)
				{
					$mt='<span class="kt-badge kt-badge--info kt-badge--inline kt-badge--pill">Video</span>';
				}
				else if($r->material_type==2)
				{
					$mt='<span class="kt-badge kt-badge--primary kt-badge--inline kt-badge--pill">PDF</span>';
				}
				else if($r->material_type==3)
				{
					$mt='<span class="kt-badge kt-badge--brand kt-badge--inline kt-badge--pill">M-Test</span>';
				}
				else if($r->material_type==4)
				{
					$mt='<span class="kt-badge kt-badge--warning kt-badge--inline kt-badge--pill">L-Test</span>';
				}

				$action='<a href="'.url('delete_comment').'/'.$r->id.'" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;';
				
			    $uData['id'] = ++$key;
				$uData['sname'] = $r->name;
				$uData['uid'] = $r->video_unique_id;
				$uData['vtitle'] =$r->title;
				$uData['mtype'] =$mt;
				$uData['cmnt'] =$r->comments;
				$uData['action'] =$action;

			    $data[] = $uData;
			}
        }

		return $data;
	}
	
public function deleteComment($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}



	
}
