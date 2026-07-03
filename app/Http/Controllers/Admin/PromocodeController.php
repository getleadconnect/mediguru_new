<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;

use Validator;
use Session;
use App\Models\Promocode;
use App\Models\User;
use DataTables;

class PromocodeController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $crs = (new Course())->getCourses(); 
	$urs = (new User())->getAllUsers(); 
	//$pcds = (new Promocode())->getPromocodes(); 
	return view('admin.promocode.promocode',compact('crs','urs'));
  }
  
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Promocode::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Promocode())->addPromocode($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Promocode successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('promocodes');
	}
	
	public function edit($id)
	{
		$crs=(new Course())->getCourses($id);
		$urs=(new User())->getAllUsers();
		$pcd=(new Promocode())->getPromocodeById($id);
		return view('admin.promocode.edit_promocode',compact('crs','pcd','urs'));
	}
	
	
	 public function update_promocode(Request $request)
	 {

		$validate=Validator::make($request->all(),Promocode::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Promocode())->updatePromocode($request);

			if($result)
			{
				Session::flash('message', 'success#Promocode successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('promocodes');
	}
	
	public function view_data(Request $request)
	{
		
		$crsid=$request->searchByCourse;
		
		if ($request->ajax()) {
            $data = (new Promocode())->viewPromocodes($crsid);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['action','desc','status'])
                    ->make(true);
        }
	}
		
	/*public function destroy($id)
	{

		$result=(new Promocode())->deletePromocode($id);
		Session::flash('message', 'success#'.$result);
		
			if($result)
			{
				Session::flash('message', 'success#Promocode successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}			

			return redirect('promocodes');
	}*/
	
  
   public function destroy($id)
	{

		$result=(new Promocode())->deletePromocode($id);
		Session::flash('message', 'success#'.$result);
		
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
	
	
	public function activate_deactivate($id,$op)
	{

		if($op==1)
		{
		   $res=['status'=>0];
		}
		else
		{
			$res=['status'=>1];
		}
		
		$result=Promocode::whereId($id)->update($res);
		
			if($result)
			{
				if($op==1)
				{
					$res=1;
				}
				else
				{
					$res=2;
				}
			}
			else
			{
				$res=3;
			}				

			return $res;
	}
	
}
