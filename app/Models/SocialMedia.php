<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model   //chapters
{
    use HasFactory;
	
	protected $table='social_medias';
	
    protected $fillable = [
      'media_name','link',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	
	public function updateSocialMediaLink($request)
	{
		
		$id=$request->smid;
				
		$dat=[
		  'link'=>$request->sm_link,
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}

	public function getSocialMediaLinks()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
	
	public function getSoicalMediaLinkById($id)
	{
		$data=self::where('id',$id)->orderBy('id','ASC')->get();
		return $data;
	}	
	
}
