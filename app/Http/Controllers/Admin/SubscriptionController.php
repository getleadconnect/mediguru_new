<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\PurchasedPackage;

use Validator;
use Session;
use DataTables;

class SubscriptionController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
 
    $crs=(new Course())->getCourses();
	return view('admin.student.subscriptions',compact('crs'));
  }
  
  public function view_data(Request $request)
  {

		$crs=$request->searchByCourse;
	    $year=$request->searchByYear;
		$search=$request->search;
		
		$qry=PurchasedPackage::query();
		
		$qry->select('purchased_packages.*','students.name','students.mobile','students.student_image','packages.package_name','courses.course_name')
				->leftJoin('students','purchased_packages.student_id','=','students.id')
				->leftJoin('packages','purchased_packages.package_id','=','packages.id')
				->leftJoin('courses','packages.course_unique_id','=','courses.unique_id')
				->where(function($where) use($search)
			    {
					$where->where('students.name', 'like', '%' .$search . '%')
					->orWhere('students.mobile', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('packages.package_name', 'like', '%' .$search . '%')
					->orWhere('purchased_packages.created_at', 'like', '%' .$search . '%');
			  });
				
		if($crs!="" and $year=="")
			$qry->where('packages.course_unique_id','=',$crs);
		else if($crs=="" and $year!="")
			$qry->whereYear('purchased_packages.created_at',$year);
		else if($crs!="" and $year!="")
			$qry->where('packages.course_unique_id','=',$crs)->whereYear('purchased_packages.created_at',$year);
		
		$data=$qry->orderBy('purchased_packages.id','DESC')->get();
		
		return DataTables::of($data)
				->addIndexColumn()
				->addColumn('simage',function($row)
				{
					return '<img src="'.config('constants.file_path').$row->student_image.'" style="width:60px">';
				})
				->addColumn('date',function($row)
				{
					return date_create($row->created_at)->format('d-m-Y');
				})
				->addColumn('name',function($row)
				{
					return strtoupper($row->name)."<br><b>Mob: </b>".$row->mobile;
				})
				->addColumn('course',function($row)
				{
					return $row->course_name;
				})
				
				->addColumn('package',function($row)
				{
					return "&bull; ".$row->package_name."<br>&bull; Expiry:<span style='color:red;font-size:11px;'>".date_create($row->subscription_end_date)->format('d-m-Y')."</span>";;
				})
				->addColumn('status',function($row)
				{
				if($row->subscription_end_date>date('Y-m-d'))
				$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Expired</span>';
				return $st;
				})

				->addColumn('action',function($row)
				{
					return '<a href="'.url('delete_subscription').'/'.$row->id.'" id="conf" class=" btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete Package" ><i class="fa fa-trash"></i></a>'; ;
				})
				
				->rawColumns(['action','name','simage','package','date','status'])
				->make(true);

  }
    
	
   public function destroy($id)
	{

		$result=(new PurchasedPackage())->deletePurchasedPackageById($id);

			if($result)
			{
				Session::flash('message', 'success#Subscription successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('subscriptions');
	}
	
}