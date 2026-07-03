<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\Course;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

use App\Models\McqQuestionPaper;
use App\Models\DashLiveMockTest;


class PackageController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs = (new Course())->getCourses();
	$sub = (new Subject())->getSubjects();
	return view('admin.package.package',compact('crs','sub'));
  }
  
   public function course_packages()
  {
	$crs = (new Course())->getCourses();
	$sub = (new Subject())->getSubjects();
	return view('admin.package.course_package',compact('crs','sub'));
  }

  /*public function group_packages()
  {
	$crs = (new Course())->getCourses();
	$sub = (new Subject())->getSubjects();
	return view('admin.package.group_package',compact('crs','sub'));
  }*/

  public function store(Request $request)   //subject package
	{
	     $result=(new Package())->addPackage($request);
		 if($result)
			{
				$res=1;
				
			}
			else
			{
				$res=0;
			}				
	
	return $res;
			//return redirect('packages');
	}		
	
	
	public function save_course_package(Request $request)
	{
	     $result=(new Package())->addCoursePackage($request);
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
	
	
	public function check_subject_package_exist($id)
	{
		$pres=0;
		$ccnt=Package::where('subject_id',$id)->where('package_type',2)->count();
		if($ccnt>0)	{ $pres=1; }else {	$pres=0;	}

	   return $pres;
	}


	public function check_course_package_exist($id)
	{
		$pres=0;
		  $crs=Course::where('id',$id)->first();
			if(!empty($crs))
			{
			   $ccnt=Package::where('course_unique_id',$crs->unique_id)->where('package_type',1)->count();
				if($ccnt>0)	{ $pres=1; }else {	$pres=0;	}
			}
	   
	   return $pres;
	}
	
	public function edit_subject_package($id)
	{
		$pkg=(new Package())->getPackageById($id);
		$crs=(new Course())->getCourses();
		$sub=(new Subject())->getSubjects();
		return view('admin.package.edit_package',compact('crs','sub','pkg'));
	}
	
	public function edit_course_package($id)
	{
		$pkg=(new Package())->getPackageById($id);
		$crs=(new Course())->getCourses();
		$sub=(new Subject())->getSubjects();
		return view('admin.package.edit_course_package',compact('crs','sub','pkg'));
	}

		
	public function update_subject_package(Request $request)
	{

		$validate=Validator::make($request->all(),Package::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Package())->updatePackage($request);

			if($result)
			{
				Session::flash('message', 'success#Package successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('packages');
	}
  
    public function update_course_package(Request $request)
	{

		$validate=Validator::make($request->all(),Package::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Package())->updateCoursePackage($request);

			if($result)
			{
				Session::flash('message', 'success#Package successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('course_packages');
	}
  
   public function destroy($id,$op)
	{

		$result=(new Package())->deletePackage($id);

			if($result)
			{
				Session::flash('message', 'success#Package successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}	
			
			if($op==1)
			{
				return redirect('packages');
			}
			else
			{
				return redirect('course_packages');
			}
	}

public function get_add_delete_subjects($id,$cuid)
{
	$p=Package::find($id);
	$subs="";
	if(!empty($p)){	$subs=$p->subject_id;}
	
	$subjs=Subject::where('course_unique_id',$cuid)->get();

	return view('admin.package.add_delete_subject',compact('subjs','id','subs'));
}


public function change_package_subjects($pid,$sids)
{

	$sids=substr($sids,0,strlen($sids)-1);
	$new=['subject_id'=>$sids];
	$result=Package::where('id',$pid)->update($new);
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


  
    public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new Package())->viewSubjectPackages($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['cname','pname','period','rate','ios_rate','action','status'])
                    ->make(true);
        }
	}
	
	
	 public function view_course_packages(Request $request)
	{

		if ($request->ajax()) {
            $data = (new Package())->viewCoursePackages($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['cname','pname','period','rate','ios_rate','action','status'])
                    ->make(true);
        }
	}
	
	
	public function get_packages_by_course_unique_id($id)
	{
		$dat=(new Package())->getPackagesByCourseUniqueId($id);
		$opt="<option value=''>--select--</option>";
			foreach($dat as $r)
			{
				if($r->package_type==1)
				{
				    $opt.="<option value='".$r->id."'>".$r->package_name." (F)</option>";
				}
				else
				{
					$opt.="<option value='".$r->id."'>".$r->package_name." (S)</option>";
				}
			}
		echo $opt;
	}
	
	
	
public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Package::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Subject successfully activated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('packages');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Package::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Subject successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('packages');
	}
	
	
	public function edit_grp_package($id)
	{
		$pkg=(new Package())->getPackageById($id);

		$spkg=[];
		if(!empty($pkg))
		{
			$ids=explode(",",$pkg->sel_package_id);
			$spkg= Package::where('package_type',1)->get();
		}
		return view('admin.package.edit_group_package',compact('pkg','spkg','ids'));
	}


	public function update_group_package(Request $request)
	{

		$validate=Validator::make($request->all(),Package::EDIT_RULES);
	
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Package())->updateGroupPackage($request);

			if($result)
			{
				Session::flash('message', 'success#Package successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing111, try again.');
			}				

			return redirect('packages');
	}


	
}