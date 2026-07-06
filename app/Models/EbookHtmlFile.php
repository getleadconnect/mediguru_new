<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EbookHtmlFile extends Model
{
    use HasFactory;
	
	protected $table='ebook_html_files';
	
    protected $fillable = [
     'ebook_id','title','html_file','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public const RULES=[
	'ebook_id'=>'required',
	'title'=>'required',
	];
	
	public const EDIT_RULES=[
  	'ed_ebook_id'=>'required',
	'ed_title'=>'required',
	'ed_title'=>'required',
	];
	
	public function addEbookHtmlFile($request)    //new
	{
		$fname1="";
		
		if($request->file('html_file'))
		{
				$ext=$request->file('html_file')->getClientOriginalExtension();
				$fna=str_replace(" ","_",$request->file('html_file')->getClientOriginalName());	 
				$fna=substr($fna,0,strpos($fna,'.'));  
				$filename = $fna."_".date('Ymdhis').".".$ext;
				$fname1 ="mediguru/ebook_html_files/".$filename;
				Storage::disk('spaces')->putFileAs("mediguru/ebook_html_files",$request->file('html_file'), $filename, 'public');
		}
		
		if($fname1=="")
		{
			$fname1="mediguru/ebook_html_files/".$request->html_file_link;
		}
		
		$result=self::create([
			'ebook_id'=>$request->ebook_id,
			'title'=>$request->title,
			'html_file'=>$fname1,
			'status'=>1
		]);
		
		return $result;
	}
	

	public function updateEbookHtmlFile($request)  //new
	{
		
		$id=$request->ed_file_id;
		$fname1=$request->ed_old_file;
		
		if(trim($request->ed_html_file_link)!="")
		{
			$fname1="mediguru/ebook_html_files/".$request->ed_html_file_link;
		}

		$dat=self::find($id);
		
		if($request->file('ed_html_file'))
		{
			if(!empty($dat))
			{
				$fna="mediguru/".$dat->html_file;
			}
			
			$ext=$request->file('ed_html_file')->getClientOriginalExtension();
			$fna=str_replace(" ","_",$request->file('ed_html_file')->getClientOriginalName());	 
			$fna=substr($fna,0,strpos($fna,'.'));  
			$filename = $fna."_".date('Ymdhis').".".$ext;
			$fname1 ="mediguru/ebook_html_files/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/ebook_html_files",$request->file('ed_html_file'), $filename, 'public');
			
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}

		$dat=[
		'ebook_id'=>$request->ed_ebook_id,
		'title'=>$request->ed_title,
		'html_file'=>$fname1,
		];
		
	
		$result=self::whereId($id)->update($dat);
		return $result;
	}

	
	public function viewEbookHtmlFiles($request)
	{
		
		$search=$request->search;
				
		$dts=self::select('ebook_html_files.*','ebooks.ebook_title')
		->leftJoin('ebooks','ebook_html_files.ebook_id','=','ebooks.id')
		->where(function($where) use($search)
			    {
					$where->where('title', 'like', '%' .$search . '%');
			  });

		$dats=$dts->orderBy('id','DESC')->get();
		
		$data = array();
		$uData = array();

        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$uData['slno'] = ++$key;
				$uData['id'] = $r->id;

				$pos =strrpos($r->html_file,'/')+1;
				$flName = substr($r->html_file, $pos);
				
				$htf='<a href="'.config('constants.file_path').$r->html_file.'" target="_blank" style="padding:3px 0px;">'.$flName.'</a>';
				$uData['ebk'] =ucfirst($r->ebook_title);
				$uData['title'] =ucfirst($r->title);
				$uData['hfile'] =$htf;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn bt-brand btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'" class=" btnDel btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}

	
		
	public function getEbookHtmlFileById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}
	
	public function deleteHtmlFile($id)
	{
		$dat=self::find($id);
		$result="";
		if(!empty($dat))
		{
			$fna1=$dat->html_file;
			
			Storage::disk('spaces')->delete($fna1);  //delete file from the disk
			
			$result=$dat->delete();
		}
		return $result;
	}
		
}
