<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use DB;

class MaterialLike extends Model
{
    use HasFactory;
	
	protected $table='material_likes';
	
    protected $fillable = [
      'student_id','video_unique_id','material_type','like','dislike',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		

	public function addMaterialsLikeDislike($request)  
	{

		return self::create([
			'student_id'=>$request->student_id,
			'video_unique_id'=>$request->video_unique_id,
			'material_type'=>$request->material_type,
			'like'=>$request->like,
			'dislike'=>$request->dislike,
		]);
	}
	
	
	public function viewMaterialLikesDislikes($request)
	{
		
		$search=$request->search;
		$mtype=$request->searchMType;
		
		
		$dts=self::select('video_unique_id','material_type','videos.video_file','videos.title',DB::raw("SUM(`like`) as sum_like"),DB::raw("SUM(`dislike`) as sum_dislike")) //,'\DB::raw("SUM(like)") as sum_like',DB::raw("SUM('dislike') as sum_dislike"))
			->leftJoin('videos','material_likes.video_unique_id','=','videos.unique_id')
			->groupBy('video_unique_id','material_type','videos.title','video_file')
			->where(function($where) use($search)
			{
				$where->where('material_likes.video_unique_id', 'like', '%' .$search . '%')
				->orWhere('videos.title', 'like', '%' .$search . '%')
				->orWhere('material_likes.material_type', 'like', '%' .$search . '%');
			});
	
			if($mtype!='')
			{
				$dts->where('material_type',$mtype);
			}
			
		$dats=$dts->orderBy('material_likes.video_unique_id','ASC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$lik1='';$lik2='';$mt='';
				
				$lik1='<span style="font-weight:600;color:green;">'.$r->sum_like.'</span>';
				
				$lik2='<span style="font-weight:600;color:red;">'.$r->sum_dislike.'</span>';
			
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

				$action='<a href="'.url('delete_like_dislike').'/'.$r->video_unique_id.'" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;';
				

				$_video="<a href='".config('constants.file_path').$r->video_file."' target='_blank'>".$r->video_unique_id."</a>";

			    $uData['id'] = ++$key;
				$uData['uid'] = $_video;
				$uData['mtitle'] =$r->title;
				$uData['mtype'] =$mt;
				$uData['lik'] =$lik1;
				$uData['dlik'] =$lik2;
				$uData['action'] =$action;

			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function deleteLikeDislike($id)
	{
		$dat=self::where('material_unique_id',$id);
		$result='';
		if(!empty($dat))
		{
		  $result=$dat->delete();
		}
		return $result;
	}

	
}
