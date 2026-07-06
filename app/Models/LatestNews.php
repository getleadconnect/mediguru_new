<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LatestNews extends Model
{
    use HasFactory;
	
	protected $table='latest_news';
	
    protected $fillable = [
      'added_date','course_id','subject_id','news_type','display_order','class_link','chat_link','class_date','title','description','news_icon','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	//'course_id'=>'required',
	//'subject_id'=>'required',
	'news_icon'=>'required',
	'news_title'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_news_id'=>'required',
	//'ed_course_id'=>'required',
	//'ed_subject_id'=>'required',
	'ed_news_title'=>'required',
	];

	public function addLatestNews($request)
	{
		
		$fname="";
		if($request->file('news_icon'))
		{
		
			$ext=$request->file('news_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/news_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/news_icons",$request->file('news_icon'), $filename, 'public');
		}
		
		return self::create([
		'added_date'=>date('Y-m-d'),
		//'course_id'=>$request->course_id,
		//'subject_id'=>$request->subject_id,
		'class_date'=>$request->class_date,
		'news_type'=>$request->news_type,
		'display_order'=>$request->display_order,
		'class_link'=>$request->event_link,
		'chat_link'=>$request->chat_link,
		'title'=>$request->news_title,
		'description'=>$request->description,
		'news_icon'=>$fname,
		'status'=>1
		]);
		
	}
		
	public function updateLatestNews($request)
	{
		
		$fname=$request->ed_lnews_icon;
		
		$id=$request->ed_news_id;
		
		if($request->file('ed_news_icon'))
		{
			
			$dat=self::find($id);
			$fna=$dat->news_icon;
		
			$ext=$request->file('ed_news_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/news_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/news_icons",$request->file('ed_news_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$dat=[
		//'course_id'=>$request->ed_course_id,
		//'subject_id'=>$request->ed_subject_id,
		'class_date'=>$request->ed_class_date,
		'news_type'=>$request->ed_news_type,
		'display_order'=>$request->ed_display_order,
		'class_link'=>$request->ed_event_link,
		'chat_link'=>$request->ed_event_link,
		'title'=>$request->ed_news_title,
		'description'=>$request->ed_description,
		'news_icon'=>$fname,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getLatestNews()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getLatestNewsById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteLatestNews($id)
	{
		$dat=self::find($id);
		$fna=$dat->news_icon;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		return $result;
	}
	
	
	public function viewLatestNews($request)  //for view lesson question papers
	{

		$search=$request->search;
			
		$dts=self::select('latest_news.*','courses.course_name','subjects.subject_name',)
		->leftJoin('courses','latest_news.course_id','=','courses.id')
		->leftJoin('subjects','latest_news.subject_id','=','subjects.id')
		->where(function($where) use($search)
			  {
				$where->where('latest_news.title', 'like', '%' .$search . '%')
				->orWhere('courses.course_name', 'like', '%' .$search . '%')
				->orWhere('subjects.subject_name', 'like', '%' .$search . '%');
			  });

		$dats=$dts->orderBy('id','DESC')->get();
		
		$data = array();
		$uData = array();
		
		
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
			    if($r->status==1)
				$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
			
				if($r->news_type==1)
				{
					$olc='<span class="kt-badge kt-badge--info  kt-badge--inline kt-badge--pill">Live Class</span>';
					$uData['title'] ="Title: ".$r->title."<br>Event: <span style='color:blue;'>".$r->class_link."</span><br>Chat: <span style='color:blue;'>".$r->chat_link."</span><br>Date: <span style='color:#ffb822;'>".$r->class_date."</span>"."<br>Listing:<b>".$r->display_order."<b>";;
					$uData['desc'] =$r->description;
				}
				else
				{   //news
					$olc='<span class="kt-badge kt-badge--warning  kt-badge--inline kt-badge--pill">News</span>';
					$uData['title'] ="Title: ".$r->title."<br>Listing:<b>".$r->display_order."<b>";
					$uData['desc'] =substr($r->description,0,100).' <a href="#" id="'.$r->id.'" class="desc_more" data-toggle="modal" title="View All"><span style="color:blue;">more</span></a>';
				}
												
				$uData['slno'] = ++$key;
				$uData['cname'] ="C: ".$r->course_name."<br>S: ".$r->subject_name;
				$uData['icon'] ='<img src="'.config('constants.file_path').$r->news_icon.'" style="width:50px;">';
				
				
				$uData['status'] ="Status: ".$st."<br>Type: ".$olc;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn bt-brand btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" id="conf" class=" btnDel btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>'; 
				
				if($r->status==1)
					  $btn.='&nbsp;<a href="#" rel=2 id="'.$r->id.'" class="act_deact btn bt-warning btn-secondary btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='&nbsp;<a href="#" rel=1 id="'.$r->id.'" class="act_deact btn bt-success btn-secondary btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	

				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	
	
}
