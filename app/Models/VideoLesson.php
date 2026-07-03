<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class VideoLesson extends Model
{
    use HasFactory;
	
	protected $table='videos';
	
    protected $fillable = [
      'unique_id','vimeo_id','icon','title',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public const RULES=[
  	   'unique_id'=>'required',
	   'vimeo_id'=>'required',
	   'title'=>'required',
	   'video_icon'=>'required',
	];
	
	public function addVideos($request)  
	{
		$fname="";

		if($request->file('video_icon'))
		{
			$ext=$request->file('video_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/video_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/video_icons",$request->file('video_icon'), $filename, 'public');
		}
		
		return self::create([
			'unique_id'=>$request->unique_id,
			'title'=>$request->title,
			'vimeo_id'=>$request->vimeo_id,
			'icon'=>$fname,
			'status'=>1
		]);
	}
	
	
	public function updateVideos($request)
	{
		
		$id=$request->ed_vid_id;
		$fname=$request->ed_vid_icon;

		if($request->file('ed_video_icon'))
		{
			
			$dat=self::find($id);
			$fna="mediguru/".$dat->video_icon;
			
			$ext=$request->file('ed_video_icon')->getClientOriginalExtension();	 
			$filename = "bnr_".date('Ymdhis').".".$ext;
			$fname ="mediguru/video_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/video_icons",$request->file('ed_video_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk

		}

		$dat=[
		'title'=>$request->ed_title,
		'vimeo_id'=>$request->ed_vimeo_id,
		'icon'=>$fname,
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

	
	public function viewVideos($request)
	{
		
		$search=$request->search;
		$crsid=$request->searchByCourse;
				
		$dts=self::select('video_lessons.*')
		->where(function($where) use($search)
			    {
					$where->where('video_lessons.title', 'like', '%' .$search . '%')
					->orWhere('video_lessons.vimeo_id', 'like', '%' .$search . '%');
			  });
		
		if($search!="" )
		{
			$dts->where('video_lessons.title',$search)->orWhere('video_lessons.vimeo_id',$search);
		}

		$dats=$dts->orderBy('video_lessons.id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['vicon'] ='<img src="'.config('constants.file_path').$r->icon.'" style="width:50px;">';
				$uData['title'] =$r->title;
				$uData['vid'] =$r->vimeo_id;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" class=" btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	
	public function getVideos($request)  //for prepare items
	{
		$search='';
		
		$dts=self::select('video_lessons.*')
		->where(function($where) use($search)
			    {
					$where->where('video_lessons.title', 'like', '%' .$search . '%')
					->orWhere('video_lessons.vimeo_id', 'like', '%' .$search . '%');
			  });
		
		if($search!="" )
		{
			$dts->where('video_lessons.title',$search)->orWhere('video_lessons.vimeo_id',$search);
		}

		$dats=$dts->orderBy('video_lessons.id','DESC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['uid'] = $r->unique_id;
				$uData['title'] =$r->title;
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
		
	public function getVideoById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function deleteVideo($id)
	{
		$dat=self::find($id);
		$fna="mediguru/".$dat->video_icon;
		Storage::disk('spaces')->delete($fna);  //delete file from the disk
		$result=$dat->delete();
		return $result;
	}
	
	
	
}
