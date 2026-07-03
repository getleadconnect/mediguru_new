<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\SocialMedia;

use Validator;
use Session;

class SocialMediaController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $sml = (new SocialMedia())->getSocialMediaLinks(); 
	return view('admin.social_media.social_media',compact('sml'));
  }
 

	public function store(Request $request)
	{
		//code here
	}
  
   public function update_social_media(Request $request)
	 {

			$result=(new SocialMedia())->updateSocialMediaLink($request);

			if($result)
			{
				$res=1;
			}
			else
			{
				$res=0;
			}				

			return $res;
	}
}
