<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Video extends Model
{
    use HasFactory;
	
	protected $table='videos';
	
    protected $fillable = [
      'unique_id','vimeo_id','premium','video_icon','video_file','icon','title',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public const RULES=[
  	   'unique_id'=>'required',
	   'premium'=>'required',
	   //'vimeo_id'=>'required',
	   'title'=>'required',
	   //'video_icon'=>'required',
	];
	
	public const EDIT_RULES=[
  	   'ed_unique_id'=>'required',
	   'ed_premium'=>'required',
	   //'ed_vimeo_id'=>'required',
	   'ed_title'=>'required',
	];
	
	/*public function addVideo($request)  
	{
		$fname="";

		if($request->file('video_icon'))
		{
			$icon=$request->file('video_icon');
			$fname=Storage::disk('local')->put('video_icons',$icon);
		}
		
		$result= self::create([
			'unique_id'=>$request->unique_id,
			'premium'=>$request->premium,
			'title'=>$request->title,
			//'vimeo_id'=>$request->vimeo_id,
			'icon'=>$fname,
			'status'=>1
		]);
		
		return $result;
		
	}*/
	
	
	public function add_Video($request)    //new
	{
		$fname1="";
		$fname2="";

		if($request->file('video_icon'))
		{
			//$icon=$request->file('video_icon');
			//$fname1=Storage::disk('local')->put('video_icons',$icon);
			
				$ext=$request->file('video_icon')->getClientOriginalExtension();	 
				$filename = "icon_".date('Ymdhis').".".$ext;
				$fname1 ="mediguru/video_icons/".$filename;
				Storage::disk('spaces')->putFileAs("mediguru/video_icons",$request->file('video_icon'), $filename, 'public');
		}
		
		if($request->file('video_file'))
		{
				$fna=str_replace(" ","_",$request->file('video_file')->getClientOriginalName());	 
				$filename = "cr_".date('Ymdhis')."_".$fna;
				$fname2 ="mediguru/video_files/".$filename;
				Storage::disk('spaces')->putFileAs("mediguru/video_files",$request->file('video_file'), $filename, 'public');
		}
		
		if($fname2=="")
		{
			$fname2="mediguru/video_files/".$request->video_file_link;
		}
		
		$result=self::create([
			'unique_id'=>$request->unique_id,
			'premium'=>$request->premium,
			'title'=>$request->title,
			'video_icon'=>$fname1,
			'video_file'=>$fname2,
			//'status'=>1
		]);
		
		return $result;
	}
	
	
	/*public function updateVideo($request)
	{
		
		$id=$request->ed_vid_id;
		$fname=$request->ed_vid_icon;

		if($request->file('ed_video_icon'))
		{
			
			$dat=self::find($id);
			$fna=$dat->video_icon;
			
			$icon=$request->file('ed_video_icon');
			$fname=Storage::disk('local')->put('video_icons',$icon);
			
			Storage::delete($fna);  //delete file from the disk

		}

		$dat=[
		'premium'=>$request->ed_premium,
		'title'=>$request->ed_title,
		'vimeo_id'=>$request->ed_vimeo_id,
		'icon'=>$fname,
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}*/
	
	
	public function update_video($request)  //new
	{
		
		$id=$request->ed_vid_id;
		$fname1=$request->ed_vid_icon;
		$fname2=$request->ed_vid_file;
		
		if($request->ed_video_file_link!="")
		{
			$fname2="mediguru/video_files/".$request->ed_video_file_link;
		}

		$dat=self::find($id);
		
		if($request->file('ed_video_icon'))
		{
			
			if(!empty($dat))
			{
				$fna=$dat->video_icon;
			}
			
			$ext=$request->file('ed_video_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname1 ="mediguru/video_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/video_icons",$request->file('ed_video_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk

		}
		
		if($request->file('ed_video_file'))
		{
			if(!empty($dat))
			{
				$fna="mediguru/".$dat->video_file;
			}
			
			$fna=str_replace(" ","_",$request->file('ed_video_file')->getClientOriginalName());	 
			$filename = "cr_".date('Ymdhis')."_".$fna;
			$fname2 ="mediguru/video_files/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/video_files",$request->file('ed_video_file'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}

		$dat=[
		'premium'=>$request->ed_premium,
		'title'=>$request->ed_title,
		'video_icon'=>$fname1,
		'video_file'=>$fname2,
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

	
	public function viewVideos($request)
	{
		
		$search=$request->search;
		$crsid=$request->searchByCourse;
				
		$dts=self::select('videos.*')
		->where(function($where) use($search)
			    {
					$where->where('videos.title', 'like', '%' .$search . '%')
					->orWhere('videos.vimeo_id', 'like', '%' .$search . '%');
			  });

		$dats=$dts->orderBy('videos.id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				
				if($r->premium==1)
				$pf='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Premium</span>';
				else
				$pf='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Free</span>';
				
				$uData['slno'] = ++$key;
				$uData['id'] = $r->id;
				
				//$uData['vicon'] ='<img src="'.url('uploads')."/".$r->icon.'" style="width:50px;">';
				
				$uData['vicon'] ='<img src="'.config('constants.file_path').$r->video_icon.'" style="width:50px;">';

				//$vv='<a href="#" res="https://player.vimeo.com/video/'.$r->vimeo_id.'" class="view_video" data-toggle="modal" title="Play video" style="padding:3px 7px 3px 7px;">'.$r->vimeo_id.'</a>';
				
				$pos =strrpos($r->video_file,'/')+1;
				$flName = substr($r->video_file, $pos);
				
				$vv='<a href="'.config('constants.file_path').$r->video_file.'" target="_blank" style="padding:3px 0px;">'.$flName.'</a>';
				$uData['title'] =ucfirst($r->title)."<br>".$vv;

				$uData['vid'] =$vv;
				$uData['pre'] =$pf;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" class=" btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
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
		$result="";
		if(!empty($dat))
		{
			$fna1=$dat->video_icon;
			$fna2=$dat->video_file;
			
			Storage::disk('spaces')->delete($fna1);  //delete file from the disk
			Storage::disk('spaces')->delete($fna2);  //delete file from the disk
			
			$result=$dat->delete();
		}
		return $result;
	}
		
	
	
}
