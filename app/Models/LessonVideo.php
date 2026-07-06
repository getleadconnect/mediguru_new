<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonVideo extends Model
{
    use HasFactory;
	
	
	protected $table='lesson_videos';
	
    protected $fillable = [
      'subject_id','lesson_id','video_unique_id','order_no'
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public function addLessonVideo($request)  
	{
		return self::create([
			'subject_id'=>$request->subject_id,
			'lesson_id'=>$request->lesson_id,
			'video_unique_id'=>$request->unique_id,
		]);
	}
		
		
	public function viewAllLessonVideos($request)  //all lesson videos
	{
		
		$search=$request->search;
		$lesid=$request->searchByLesson;
				
		$dts=self::select('lesson_videos.*','videos.title','videos.video_icon','videos.video_file','subjects.subject_name','lessons.lesson_name')
		->leftJoin('videos','lesson_videos.video_unique_id','=','videos.unique_id')
		->leftJoin('lessons','lesson_videos.lesson_id','=','lessons.id')
		->leftJoin('subjects','lesson_videos.subject_id','=','subjects.id')
		->where(function($where) use($search)
			{
				$where->where('videos.title', 'like', '%' .$search . '%')
				->orWhere('lesson_videos.video_unique_id', 'like', '%' .$search . '%')
				->orWhere('videos.vimeo_id', 'like', '%' .$search . '%');
			});
		
		if($lesid!="" )
		{
			$dts->where('lesson_videos.lesson_id',$lesid);
		}
				

		$dats=$dts->orderBy('lesson_videos.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
			    
				$fna="";
				if($r->video_file!="")
				{
				   $pos=explode('/',$r->video_file);
				   $fna=(count($pos)>2)?$pos[2]:$pos[1];
				}
				
				$uData['id'] = ++$key;
				$uData['uid'] = $r->video_unique_id;
				$uData['vicon'] ='<img src="'.config('constants.file_path').$r->video_icon.'" style="width:50px;">';
				$uData['vfile'] ='<a href="'.config('constants.file_path').$r->video_file.'" target="_blank">'.$fna.'</a>';
				$uData['sname'] =$r->subject_name;
				$uData['lname'] =$r->lesson_name;
				$uData['title'] =$r->title;
			
				$btn='<a href="#" id="'.$r->id.'" class="btnDel btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	
	
	public function getVideos($request)  //for prepare items
	{
		$search=$request->search;
		
		$dts=Video::select('videos.*')
		->where(function($where) use($search)
			    {
					$where->where('videos.title', 'like', '%' .$search. '%')
					->orWhere('videos.unique_id', 'like', '%' .$search. '%')
					->orWhere('videos.vimeo_id', 'like', '%' .$search. '%');
			  });


		$dats=$dts->orderBy('videos.id','DESC')->get();
		
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
	
	
	
		
	public function LessonVideos($request)  //get lesson items
	{
		$lesid=$request->searchByLesson;
		
		$dats=self::select('lesson_videos.*','videos.title','videos.video_icon','videos.video_file')
		->leftJoin('videos','lesson_videos.video_unique_id','=','videos.unique_id')
		->where('lesson_videos.lesson_id',$lesid)
		->orderBy('lesson_videos.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$fna="";
				if($r->video_file!="")
				{
				   $pos=explode('/',$r->video_file);
				   $fna=(count($pos)>2)?$pos[2]:$pos[1];
				}
								
			    $uData['id'] = ++$key;
				$uData['uid'] = $r->lesson_unique_id;
				$uData['icon'] ='<img src="'.config('constants.file_path').$r->icon.'" style="width:50px;">';
				$uData['vicon'] ='<img src="'.config('constants.file_path').$r->video_icon.'" style="width:50px;">';
				$uData['vfile'] ='<a href="'.config('constants.file_path').$r->video_file.'" target="_blank">'.$fna.'</a>';
				$uData['title'] =$r->title;
				
				
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
				
				$uData['dat'] ="<span style='font-size:12px;'>Uid : ".$r->video_unique_id."<br>Vid : <b>".$r->vimeo_id."</b><br>Title : ".$r->title."</span>";
				
				$uData['action'] ='<a href="#" id="'.$r->id.'" class="btnDel btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" style="width:1.75rem;height:1.75rem;" title="Delete"><i class="fa fa-trash"></i></a>';
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	
	
	public function getLessonItems()
	{
		$data=self::select('lesson_videos.*')->orderBy('id','ASC')->get();
		return $data;
	}
	
		
	public function getLessonVideoById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function deleteLessonVideo($id)
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
