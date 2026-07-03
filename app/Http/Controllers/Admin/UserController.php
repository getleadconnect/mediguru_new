<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Student;
use App\Models\PurchasedPackage;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Course;
use App\Models\MenuOption;

use Validator;
use Session;
use DataTables;
use DB;

class UserController extends Controller
{
    
  public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs=(new Course())->getCourses();
	return view('admin.user.student_user',compact('crs'));
  }

  public function destroy($id)
	{

		$udt=(new User())->getUserById($id);
		$stid=$udt->student_id;
		
		$result=(new User())->deleteUser($id);
		$res1=(new Student())->deleteStudent($stid);
		$res2=(new PurchasedPackage())->deletePurchasedPackageByStudentId($stid);

			if($result)
			{
				Session::flash('message', 'success#User successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

		return redirect('student_users');
		
	}
  
   public function edit($id)
    {
        $us = User::find($id);
		return view('admin.user.edit_student_user',compact('us'));
    }

   public function update_student_user(Request $request)
    {
	  
		$result=(new User())->updateStudentUser($request);
		  
		  if($result)
		  {
			Session::flash('message', 'success#User successfully updated.'.$result);
		  }
		  else
		  {
			Session::flash('message', 'danger#Something wrong, try again.'.$result);
		  }		
	  
		return redirect('student_users');
    }
 
 
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new User())->getUsers($request);
            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','status'])
                    ->make(true);
        }
	}

	
   public function get_packages_by_course_id($id)
	{
		$dat=(new Package())->getPackagesByCourseId($id);
		$opt="<option value=''>--select--</option>";
			foreach($dat as $r)
			{
				$opt.="<option value='".$r->id."'>".$r->package_name."</option>";
			}
		echo $opt;
	}
	
		
	public function activate($id)
	{

		$res=['status'=>1];
		
		$result=User::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#User successfully activated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('student_users');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=User::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#User successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('student_users');
	}

	
	//admin user details
	
 public function admin_users()
  {
	$role=(new Role())->getRoles();
	return view('admin.user.admin_user',compact('role'));
  }	


  public function add_admin_user(Request $request)
  {
	  $aur=Admin::where('email',$request->email)->count();
	  if($aur>0)
	  {
		Session::flash('message', 'danger#Email already exist. Try again.');  
	  }
	  else
	  {
			
		  $result=(new Admin())->addAdminUser($request);
		  
		  if($result)
			{
				Session::flash('message', 'success#Admin user successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}		
	  }		

		return redirect('admin_users');
  }

 public function edit_admin_user($id)
    {
        $au = Admin::find($id);
		$rol = Role::where('id','!=',1)->orderBy('id','ASC')->get();
		return view('admin.user.edit_admin_user',compact('au','rol'));
    }


public function update_admin_user(Request $request)
  {
	  
		$result=(new Admin())->updateAdminUser($request);
		  
		  if($result)
			{
				Session::flash('message', 'success#Admin user successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}		
	  
		return redirect('admin_users');
  }



    public function remove_user($id)   //admin user
	{

		$result=(new Admin())->deleteAdminUser($id);
		
			if($result)
			{
				Session::flash('message', 'success#User successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('admin_users');
	}
  
    public function view_admin_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new Admin())->getAdminUsers($request);
            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['action','status','smenu'])
                    ->make(true);
        }
	}

		
	public function activate_admin($id)
	{

		$res=['status'=>1];
		
		$result=Admin::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#User successfully activated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('admin_users');
	}
	
	
	public function deactivate_admin($id)
	{

		$res=['status'=>0];
		
		$result=Admin::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#User successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('admin_users');
	}





		
	
}