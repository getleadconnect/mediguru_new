<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookTitle extends Model
{
    use HasFactory;

	protected $table='ebook_titles';
	
    protected $fillable = [
      'ebook_title','status',
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

	public function addEbookTitle($request)
	{

		   $res=self::create([
			'ebook_title'=>$request->ebook_title,
			'status'=>1
			]);
		return $res;
	}
	
    public function updateEbookTitle($request)
	{
		$id=$request->ed_ebook_id;
	
		$dat=[
			'ebook_title'=>$request->ed_ebook_title,
			];
			
		$res=self::where('id',$id)->update($dat);
		
		return $res;
	}

	public function viewEbookTitles()
	{
		
		$dts=self::select('ebook_titles.*')->orderBy('id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $key=>$r)
            {
			    $uData['id'] = ++$key;
				$uData['btitle']=$r->ebook_title;
				
				$btn='<a href="#" id="'.$r->id.'" data-val="'.$r->ebook_title.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon"  data-toggle="modal" data-target="#kt_modal_1"  title="Edit"><i class="fa fa-edit"></i></a> 
					 <a href="#" id="'.$r->id.'"  class="btndel btn btn-danger btn-elevate btn-circle btn-icon"  title="Delete"><i class="fa fa-trash"></i></a>'; 
			
				$uData['action'] = $btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	public function getEbookTitles()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getEbookTitleById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteEbookTitle($id)
	{
		$result=self::find($id)->delete();

		return $result;
	}
	
	
}
