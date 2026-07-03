<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class VimeoVideo extends Model
{
    use HasFactory;
	
	protected $table='vimeo_videos';
	
    protected $fillable = [
      'course_id','video_id','video_title','description',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	
	public function viewVimeoVideos($request)
	{
		
		$search=$request->search;
		$crsid=$request->searchByCourse;
				
		$dts=self::select('vimeo_videos.*','courses.course_name')
		->leftJoin('courses','vimeo_videos.course_id','=','courses.id')
		->where(function($where) use($search)
			    {
					$where->where('vimeo_videos.video_title', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('vimeo_videos.description', 'like', '%' .$search . '%');
			  });
		
		if($crsid!="" )
		{
			$dts->where('vimeo_videos.course_id',$crsid);
		}

		$dats=$dts->orderBy('vimeo_videos.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
			    $uData['id'] = $r->id;
				$uData['crs'] =$r->course_name;
				$uData['vid'] =$r->video_id;
				$uData['vtitle'] =$r->video_title;
				$uData['vdesc'] =$r->description;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="'.url('delete_vimeo_video').'/'.$r->id.'" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function getVimeoVideos()
	{
		$data=self::select('vimeo_videos.*','courses.course_name')
		->leftJoin('courses','vimeo_videos.course_id','courses.id')->orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getVimeoVideosByCourseId($id)
	{
		$data=self::select('vimeo_videos.*','courses.course_name')
		->leftJoin('courses','vimeo_videos.course_id','courses.id')
		->where('course_id',$id)->orderBy('id','ASC')->get();
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
		$fna=$dat->video_icon;
		$result=$dat->delete();
			Storage::delete($fna);  //delete file from the disk
		return $result;
	}
	
	
	public function updateVideo($request)
	{
		
		$id=$request->ed_vid_id;

		$dat=[
		'course_id'=>$request->ed_course_id,
		'video_title'=>$request->ed_video_title,
		'video_id'=>$request->ed_video_id,
		'description'=>$request->ed_description,
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

	
}
