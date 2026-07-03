<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DashboardBanner extends Model
{
    use HasFactory;
	
	
	protected $table='dashboard_banners';
	
    protected $fillable = [
      'banner_image','banner_section','status',
    ];
		
	public const RULES=['banner_image'=>'required',
						'banner_section'=>'required'
					   ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions

public function addBanner($request)
	{
		
		$fname="";
		if($request->file('banner_image'))
		{

			$ext=$request->file('banner_image')->getClientOriginalExtension();	 
			$filename = "bnr_".date('Ymdhis').".".$ext;
			$fname ="mediguru/dash_banner/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/dash_banner",$request->file('banner_image'), $filename, 'public');

		}
		
		return self::create([
		'banner_image'=>$fname,
		'banner_section'=>$request->banner_section,
		'status'=>1
		]);
		
	}
		
	public function updateBanner($request)
	{
		
		$fname=$request->bnr_image;
		
		$id=$request->bnr_id;
		
		if($request->file('banner_image'))
		{
			
			$dat=self::find($id);
			$fna=$dat->banner_image;
						
			$ext=$request->file('banner_image')->getClientOriginalExtension();	 
			$filename = "bnr_".date('Ymdhis').".".$ext;
			$fname ="mediguru/dash_banner/".$filename;
			Storage::disk('spaces')->putFileAs("mediguru/dash_banner",$request->file('banner_image'), $filename, 'public');
		
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		}
		
		$dat=[
		'banner_section'=>$request->banner_section,
		'banner_image'=>$fname,
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getBanners()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getBannerById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteBanner($id)
	{
		$dat=self::find($id);
		$fna=$dat->banner_image;
		$result=$dat->delete();
			Storage::disk('spaces')->delete($fna);  //delete file from the disk
		return $result;
	}
}
