<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ClassVideo extends Model
{
    use HasFactory;
	
	protected $table='class_videos';
	
    protected $fillable = [
      'course_id','subject_id','chapter_id','video_title','video_id','video_icon','description','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'course_id'=>'required',
	'subject_id'=>'required',
	'chapter_id'=>'required',
	'video_id'=>'required',
	'video_icon.*'=>'required',
	];
		
	public const EDIT_RULES=[
	'ed_course_id'=>'required',
	'ed_subject_id'=>'required',
	'ed_chapter_id'=>'required',
	'ed_video_id'=>'required',
	'ed_video_title'=>'required',
	];

	public function addMultipleVideos($request)  //vimeo id  only
	{
		$fname="";
		$res=false;

		 if($request->hasfile('icon'))
         {
			$imgna=[];
            foreach($request->file('icon') as $icon)
            {
                $ext=$icon->getClientOriginalExtension();
				//$fname="video_icons/"."icon_".date('Ymdhis').".".$ext;
                //$image->move(public_path().'/images/', $name);  
				$fname=Storage::disk('local')->put('video_icons',$icon);
                $imgna[] = $fname;  
            }
         }
	
		for($x=0;$x<count($imgna);$x++)
		{
			$vv=VimeoVideo::where('video_id',$request->video_id[$x])->first();
			
			$res=self::create([
				'course_id'=>$request->course_id,
				'subject_id'=>$request->subject_id,
				'chapter_id'=>$request->chapter_id,
				'video_id'=>$request->video_id[$x],
				'video_title'=>$vv->video_title,
				'description'=>$vv->description,
				'video_icon'=>$imgna[$x],
				'status'=>1
			]);
		}
		
		return $res;
	}
	
	
	public function addSingleVideo($request)  
	{
		$fname="";
		if($request->file('video_icon'))
		{
			$icon=$request->file('video_icon');
            $ext=$request->file('video_icon')->getClientOriginalExtension();
			$fname="video_icons/"."icon_".date('Ymdhis').".".$ext;
			Storage::disk('local')->put($fname, file_get_contents($icon));
			
			//$icon->move(public_path('uploads/course_icons'), $fname);
			//Storage::disk('s3')->put($fname, file_get_contents($request->file('dv_file')),'public');
		}
		
		return self::create([
			'course_id'=>$request->course_id,
			'subject_id'=>$request->subject_id,
			'video_title'=>$request->video_title,
			'video_id'=>$request->video_id,
			'description'=>$request->description,
			'video_icon'=>$fname,
			'status'=>1
		]);
	}
		
	public function updateClassVideo($request)
	{
		
		$fname=$request->ed_cvid_icon;
		
		$id=$request->ed_cvid_id;
		
		if($request->file('ed_video_icon'))
		{
			
			$dat=self::find($id);
			$fna=$dat->video_icon;
						
			$icon=$request->file('ed_video_icon');
            $ext=$request->file('ed_video_icon')->getClientOriginalExtension();
			//$fname="video_icons/"."icon_".date('Ymdhis').".".$ext;
			$fname=Storage::disk('local')->put('video_icons',$icon);
			
			Storage::delete($fna);  //delete file from the disk
		}
		
		$dat=[
		'course_id'=>$request->ed_course_id,
		'subject_id'=>$request->ed_subject_id,
		'chapter_id'=>$request->ed_chapter_id,
		'video_title'=>$request->ed_video_title,
		'video_id'=>$request->ed_video_id,
		'description'=>$request->ed_description,
		'video_icon'=>$fname,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getVideos()
	{
		$data=self::select('class_videos.*','courses.course_name','subjects.subject_name','chapters.chapter_name')
		->leftJoin('courses','class_videos.course_id','=','courses.id')
		->leftJoin('subjects','class_videos.subject_id','=','subjects.id')
		->leftJoin('chapters','class_videos.chapter_id','=','chapters.id')
		->orderBy('id','ASC')->get();
		return $data;
	}
	
	public function viewClassVideos($request)
	{
		
		$search=$request->search;
		$crsid=$request->searchByCourse;
		$scrsid=$request->searchBySubcourse;
		$chaid=$request->searchByChapter;
				
		$dts=self::select('class_videos.*','courses.course_name','subjects.subject_name','chapters.chapter_name')
			->leftJoin('courses','class_videos.course_id','=','courses.id')
			->leftJoin('subjects','class_videos.subject_id','=','subjects.id')
			->leftJoin('chapters','class_videos.chapter_id','=','chapters.id')
			->where(function($where) use($search)
			{
				$where->where('class_videos.video_title', 'like', '%' .$search . '%')
				->orWhere('courses.course_name', 'like', '%' .$search . '%')
				->orWhere('subjects.subject_name', 'like', '%' .$search . '%')
				->orWhere('chapters.chapter_name', 'like', '%' .$search . '%');
			});
		
		if($crsid!="" and $scrsid=="" and $chaid=="")
		{
			$dts->where('class_videos.course_id',$crsid);
		}
		else if($crsid!="" and $scrsid!="" and $chaid=="")
		{
			$dts->where('class_videos.subject_id',$scrsid);
		}
		else if($crsid=="" and $scrsid=="" and $chaid!="")
		{
			$dts->where('class_videos.chapter_id',$chaid);
		}
		
		$dats=$dts->orderBy('class_videos.id','ASC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
				if($r->status==1)
				$st='<span class="kt-badge kt-badge--success kt-badge--inline kt-badge--pill">Active</span>';
				else
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
				
			    $uData['id'] = $r->id;
				$uData['cicon'] ='<img src="'.url('uploads')."/".$r->video_icon.'" style="width:60px">';
				$uData['cname'] =$r->course_name;
				$uData['sname'] =$r->subject_name;
				$uData['chname'] =$r->chapter_name;
				$uData['vtit'] =$r->video_title;
				$uData['vid'] =$r->video_id;
				$uData['desc'] =$r->description;
				$uData['status'] =$st;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" class="btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				if($r->status==1)
					  $btn.='<a href="'.url('deactivate_class_video').'/'.$r->id.'" class="btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_class_video').'/'.$r->id.'" class="btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	public function getClassVideoById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function getVideosByChapterId($id)
	{
		$data=self::where('chapter_id',$id)->orderBy('id','ASC')->get();
		return $data;
	}	
	
	public function deleteClassVideo($id)
	{
		$dat=self::find($id);
		$fna=$dat->video_icon;
		 Storage::delete($fna);  //delete file from the disk
		$result=$dat->delete();
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
}
