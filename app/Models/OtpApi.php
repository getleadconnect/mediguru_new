<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OtpApi extends Model
{
    use HasFactory;
	
	protected $table='otp_api';
	
    protected $fillable = ['api_url','status'];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
		
	public function addOtpApi($request)
	{
		$dat=['status'=>0];
		$res=OtpApi::where('status',1)->update($dat);
				
		return self::create([
		'api_url'=>$request->api_url,
		'status'=>1
		]);
		
	}
	
	public function updateOtpApi($request)
	{
		$id=$reuqest->api_id;
		
		$dat=['status'=>0];
		$res=OtpApi::where('status',1)->update($dat);
				
		$new=[
		'api_url'=>$request->api_url,
		'status'=>1
		];
		
		$result=OtpApi::where('id',$id)->update($new);
		
		return $result;
	}
		
	
	public function getOtpApi()
	{
		$data=self::where('status',1)->orderBy('id','ASC')->first();
		return $data;
	}
	
		
	public function getOtpApiById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteOtpApi($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		
		return $result;
	}
	
	
}
