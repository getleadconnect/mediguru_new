<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Session;

class Ebook extends Model
{
    use HasFactory;

	protected $table='ebooks';
	
    protected $fillable = [
      'ebook_title','ebook_icon','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public const RULES=[
	'ebook_title'=>'required',
	];
	
	public const EDIT_RULES=[
	'ed_ebook_title'=>'required',
	];
		
	//fucntions

	public function addEbook($request)
	{

		$fname="";
		if($request->file('ebook_icon'))
		{
			
			$ext=$request->file('ebook_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/ebook_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/ebook_icons",$request->file('ebook_icon'), $filename, 'public');
		}

		   $res=self::create([
			'ebook_title'=>$request->ebook_title,
			'ebook_icon'=>$fname,
			'status'=>1
			]);
		return $res;
	}
	
    public function updateEbook($request)
	{
		$id=$request->ed_ebook_id;
		$fname=$request->ed_ebk_icon;
		
		if($request->file('ed_ebook_icon'))
		{
			$dat=self::find($id);
			$fna=$dat->ebook_icon;
			
			$ext=$request->file('ed_ebook_icon')->getClientOriginalExtension();	 
			$filename = "icon_".date('Ymdhis').".".$ext;
			$fname ="mediguru/ebook_icons/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/ebook_icons",$request->file('ed_ebook_icon'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$dat=[
			'ebook_title'=>$request->ed_ebook_title,
			'ebook_icon'=>$fname,
			];
			
		$res=self::where('id',$id)->update($dat);
		
		return $res;
	}

	public function viewEbooks()
	{
		
		$dts=self::select('ebooks.*')->orderBy('id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $key=>$r)
            {
			    $uData['id'] = ++$key;
				$uData['btitle']=$r->ebook_title;
				$uData['eimg']="<img src='".config('constants.image_path').$r->ebook_icon."' style='width:60px;'>";
				$btn='<a href="#" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon"  data-toggle="modal" data-target="#kt_modal_1"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'"  class="btndel btn btn-danger btn-elevate btn-circle btn-icon"  title="Delete"><i class="fa fa-trash"></i></a>'; 
			
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function getEbooks()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getEbookById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteEbook($id)
	{
		
		$dat=self::find($id);
		$fna=$dat->ebook_icon;
		$result=$dat->delete();
		
		Storage::disk('spaces')->delete($fna);  //delete file from the disk

		return $result;
	}
	
	
}
