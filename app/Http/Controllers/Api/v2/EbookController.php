<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Models\Ebook;
use App\Models\EbookHtmlFile;


class EbookController extends Controller
{
	
   /**
	 * Function get_ebook_titles
	 * Function to list ebook titles
	 * @param: mone
	 * return [ states]
	 */

   public function get_ebook_titles() 
	{
		$edat = Ebook::where('status',1)->orderBy('id','ASC')->get();
		
		$data=[];
		$uData=[];
		
	    if(!$edat->isEmpty()) 
		{
			foreach($edat as $r)
			{
				$cnt=EbookHtmlFile::where('ebook_id',$r->id)->count();
				
				$uData['id']=$r->id;
				$uData['ebook_title']=$r->ebook_title;
				$uData['ebook_icon']=$r->ebook_icon;
				$uData['chapter_count']=$cnt??0;
				$uData['status']=$r->status;
				$data[]=$uData;
			}
			
			$response = [
				'status'=>TRUE,
				'ebooks'=>$data,
				'image_path'=>config('constants.image_path'),
			];
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
		}
		
		return response($response, 200);
    }	


/**
 * Function get_courses
 * Function to list courses
 * Method:GET
 * @param: mone
 * return [ courses]
 */
	 
 // include social media links for navigation bar

   public function get_ebook_files(Request $request) 
	{
		$ebid=$request->ebook_id;
		
		$efiles = EbookHtmlFile::where('ebook_id',$ebid)->where('status',1)->orderBy('id','ASC')->get(); 
		
	    if(!$efiles->isEmpty()) 
		{
			$response = [
				'status'=>TRUE,
				'ebook_files'=>$efiles,
				'file_path'=>config('constants.file_path'),
			];
			return response($response, 200);
		}
		else {
			$response = ['status'=>FALSE, "message" => "No data were found."];
			return response($response, 200);
		}
    }

}
