<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\DashboardBanner;

use Session;
use Validator;

class DashboardBannerController extends Controller
{
       
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $bnr = (new DashboardBanner())->getBanners(); 
	return view('admin.dashboard_banner.banner',compact('bnr'));
  }
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),DashboardBanner::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new DashboardBanner())->addBanner($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Banner successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('banners');
	}
	
	public function edit($id)
	{
		$bnr=(new DashboardBanner())->getBannerById($id);
		return view('admin.dashboard_banner.edit_banner',compact('bnr'));
	}
	
	
	 public function update_banner(Request $request)
	 {

		$validate=Validator::make($request->all(),DashboardBanner::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new DashboardBanner())->updateBanner($request);

			if($result)
			{
				Session::flash('message', 'success#Banner successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('banners');
	}
  
   public function destroy($id)
	{

		$result=(new DashboardBanner())->deleteBanner($id);
		if($result)
			{
				Session::flash('message', 'success#Banner successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('banners');
	}
	
	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=DashboardBanner::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Banner successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('banners');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=DashboardBanner::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Banner successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('banners');
	}
}
