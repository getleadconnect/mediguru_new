<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Staff;

use Validator;
use Session;

use DataTables;

class StaffController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {

    $stf = (new Staff())->getStaffs(); 
	//$pcds = (new Promocode())->getPromocodes(); 
	return view('admin.staff.staff',compact('stf'));
  }
  
  
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Staff::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		try
		{
			$result=(new Staff())->addStaff($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Staff details successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				
		}
		catch(\Exception $e)
		{
			Session::flash('message', 'danger#Referral-code duplication not allowed.');
		}
			return redirect('staffs');
	}
	
	public function edit($id)
	{
		$stf=(new Staff())->getStaffById($id);
		return view('admin.staff.edit_staff',compact('stf'));
	}
	
	
	 public function update_staff(Request $request)
	 {

		$validate=Validator::make($request->all(),Staff::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Staff())->updateStaff($request);

			if($result)
			{
				Session::flash('message', 'success#Staff details successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('staffs');
	}
	
	public function view_data(Request $request)
	{
		if ($request->ajax()) {
            $data = (new Staff())->getStaffs();
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}
		
public function check_referral_code($code)
{
	$res=Staff::where('referral_code',$code)->count();
	if($res>0)
		echo 1;
	else
		echo 0;
}
  
   public function destroy($id)
	{

		$result=(new Staff())->deleteStaff($id);
		Session::flash('message', 'success#'.$result);
		
			if($result)
			{
				Session::flash('message', 'success#Staff details successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}			

			return redirect('staffs');
	}
	
	
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Staff::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Staff details successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('staffs');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Staff::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Staff details successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('staffs');
	}
	
}
