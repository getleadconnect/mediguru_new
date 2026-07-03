<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Student;
use App\Models\PurchasedPackage;
use Session;

class ChatData extends Model
{
    use HasFactory;
	
	protected $table='chat_datas';
	
    protected $fillable = [
     'course_unique_id','student_id','admin_id','user_type','message','pictures','status','created_at'
    ];

    protected $hidden = [
		'updated_at',
    ];
		
	//fucntions
	

	public function addAdminMessage($request)
	{
		
		$pc=PurchasedPackage::where('student_id',$request->stud_id)->first();
		$cuid=null;
		if(!empty($pc))
		{
			$cuid=$pc->course_unique_id;
		}
		
			return self::create([
			'course_unique_id'=>$cuid,
			'student_id'=>$request->stud_id,
			'admin_id'=>$request->admin_id,
			'message'=>$request->message,
			'user_type'=>2,
			'status'=>1
			]);
	}
		
	
	public function addImage($request)
	{
		$fname='';
		if($request->file('file1'))
		{
			$ext=$request->file('file1')->getClientOriginalExtension();	 
			$filename = "img_".date('Ymdhis').".".$ext;
			$fname ="mediguru/chat_images/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/chat_images",$request->file('file1'), $filename, 'public');
	
		}

		$result=self::create([
		'student_id'=>$request->student_id1,
		'admin_id'=>$request->admin_id1,
		'message'=>Null,
		'pictures'=>$fname,
		'user_type'=>2,
		'status'=>1
		]);
		
		return $fname;
	}

	public function getStudentMessages($id)
	{
		$result= self::where('student_id',$id)->get();
		return $result;
	}
	
	public function getChatStudents()
	{
		$result=Student::select('students.id as stud_id','students.name','students.mobile')
		->Join('chat_datas','students.id','=','chat_datas.student_id')
		->groupBy('stud_id','students.name','students.mobile')->orderBy('stud_id','ASC')->get();
		
		foreach($result as $key=>$r)
		{
			$cnt=ChatData::where('student_id',$r->stud_id)->where('status',1)->count();
			$result[$key]->new_chat_count=$cnt;
		}
		
		return $result;
	}
		
	
	public function viewChatStudents($request)
	{
		$search=$request->search;
				
		$dts=Student::select('students.id as stud_id','students.name','students.mobile')
		->Join('chat_datas','students.id','=','chat_datas.student_id')
		->groupBy('stud_id','students.name','students.mobile')
			->where(function($where) use($search)
			{
				$where->where('students.name', 'like', '%' .$search . '%');
				
			});
		
		$dats=$dts->orderBy('stud_id','ASC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $r)
            {
				
				$cnt=ChatData::where('student_id',$r->stud_id)->where('status',1)->count();
				
					$na=substr($r->name, 0, 1);
					if(strpos($r->name," ")!="")
					{
					   $na.=substr($r->name,strpos($r->name," ")+1, 1);
					}

					$uData['studs'] ='<div class="kt-widget__item">
								<span class="kt-media kt-media--circle">
									<!--<img src="assets/media/users/300_9.jpg" alt="image"> -->
									<div class="chat-icon-sm" style="background:#24578a !important;font-size:15px;margin-top:2px; ">'.strtoupper($na).'</div>
								</span>
								<div class="kt-widget__info">
									<div class="kt-widget__section">
										<a href="#" class="stud_name kt-widget__username" id="'. $r->stud_id.'">'.$r->name.'</a>';
									$cont='';
									if($cnt>0)
									{
									    $cont='<div id="chat_count"><span class="kt-badge kt-badge--success kt-font-bold">'.$cnt.'</span></div>';
									}
									
					$uData['studs'].=$cont.'</div>
									<span class="kt-widget__desc">'.$r->mobile.'</span>
								</div>
								<div class="kt-widget__action">
									<span class="kt-widget__date">&nbsp;</span>
									<!-- content here -->
								</div>
								</div>';
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	
	public function deleteChatMessageById($id)
	{
		$cdt= self::where('id',$id)->first();

		if(!empty($cdt))
		{
			if($cdt->pictures!='')
			{
				/*$fna1="uploads/".$cdt->pictures;
				 if(file_exists($fna1))
				 {
					 $fn1="uploads/$cdt->pictures";
					 unlink($fn1);
				 }*/
				$fna1=$cdt->pictures;
				Storage::disk('spaces')->delete($fna1); 
				 
			}
		    $res=$cdt->delete();
		}
		else 
		{
			$res=0;
		}
		return $res;
	}
	
	
	public function getStudentChatMessages($id)
	{
		$result=self::select('chat_datas.*','students.name','students.mobile')
		->leftJoin('students','chat_datas.student_id','=','students.id')
		->where('chat_datas.student_id',$id)->orderBy('chat_datas.id','ASC')->get();
				
		$msdt="";
		$x=1;
		foreach($result as $key=>$r)
		{
			$na=substr($r->name, 0, 1);
			if(strpos($r->name," ")!="")
			{
			   $na.=substr($r->name,strpos($r->name," ")+1, 1);
			}

			if($r->user_type==1)
			{
				
				$msdt.='<div class="kt-chat__message" id="con-'.$x.'">
					<div class="kt-chat__user">
					  <div class="row">
						<div class="col-lg-1">
						<span class="kt-media kt-media--circle kt-media--sm">
							<!--<img src="assets/media/users/100_12.jpg" alt="image">-->
							<div class="chat-icon-sm" style="background:#24578a !important;font-size:15px;margin-top:2px; ">'.strtoupper($na).'</div>
						</span>
						</div>
						
						<div class="col-lg-11">
							<div class="row">
							<div class="col-lg-12">
							<span class="kt-chat__username">'.ucfirst(strtolower($r->name)).'</span>
							<span class="kt-chat__datetime">'.date_create($r->created_at)->format('d-m-Y h:i:s A').'</span>
							</div>
							
							<div class="col-lg-11">';
							
							if($r->pictures!="")
							{
								$msdt.='<img onclick="view_image(this)" src="uploads/'.$r->pictures.'" style="width:150px;height:100px;">';
							}
							else
							{
								$msdt.='<div class="kt-chat__text kt-bg-light-success">'.$r->message.'</div>';
							}
							$msdt.='</div>
							<div class="col-lg-1">
							<a href"#" class="btnDel" onclick="deleteChat(this)" data-id="con-'.$x.'" id="'.$r->id.'-100"style="color:#f77b7b;" ><i class="fa fa-trash"></i></a>
							</div>
							
							</div>
						</div>
					  </div>
					</div>
					
				</div>';
			}
			else
			{
											
				$msdt.='<div class="kt-chat__message" id="con-'.$x.'">
					<div class="kt-chat__user">
					  <div class="row">
						<div class="col-lg-1">
						<span class="kt-media kt-media--circle kt-media--sm">
							<!--<img src="assets/media/users/100_12.jpg" alt="image">-->
							<div class="chat-icon-sm" style="background:#034e14 !important;font-size:15px;margin-top:2px; ">Ad</div>
						</span>
						</div>
						
						<div class="col-lg-11">
							<div class="row">
							<div class="col-lg-12">
							<span class="kt-chat__username"><b>You</b></span>
							<span class="kt-chat__datetime">'.date_create($r->created_at)->format('d-m-Y h:i:s A').'</span>
							</div>
							
							<div class="col-lg-11">';
							
							if($r->pictures!="")
							{
								$msdt.='<img onclick="view_image(this)" src="'.config('constants.file_path').$r->pictures.'" style="width:150px;height:100px;">';
							}
							else
							{
								$msdt.='<div class="kt-chat__text kt-bg-light-success">'.$r->message.'</div>';
							}
							$msdt.='</div>
							<div class="col-lg-1">
							<a href"#" class="btnDel" onclick="deleteChat(this)" data-id="con-'.$x.'" id="'.$r->id.'" style="color:#f77b7b;"><i class="fa fa-trash"></i></a>
							</div>
							
							</div>
						</div>
					  </div>
					</div>
					
				</div>';
				
			}
			$x++;
		}
		
		$new=['status'=>0];
		$res=ChatData::where('chat_datas.student_id',$id)->update($new);
		
		return $msdt;
	}
	
}
