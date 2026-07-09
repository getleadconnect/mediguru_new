<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Student;
use App\Models\Subscription;
use App\Models\PurchasedPackage;
use App\Exports\PackageSubscriptionListExport;

use Validator;
use Session;
use DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;

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
		$plan=$request->searchPlan;  //3 , 6, 12 months
		
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

		//filter by plan (3, 6, 12 months) - based on month difference of subscription start & end date
		if($plan!="")
			$qry->whereRaw('TIMESTAMPDIFF(MONTH, purchased_packages.subscription_start_date, purchased_packages.subscription_end_date) = ?',[$plan]);


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

				->addColumn('period',function($row)
				{
					$difMonth='';
					if($row->subscription_start_date!="" and $row->subscription_end_date!="")
						$difMonth=Carbon::parse($row->subscription_start_date)->diffInMonths(Carbon::parse($row->subscription_end_date));
					if($difMonth==3)       $color='#0a8f5b';   // 3 Months  - green
					elseif($difMonth==6)   $color='#e08e0b';   // 6 Months  - amber
					elseif($difMonth==12)  $color='#c0392b';   // 12 Months - red
					else                   $color='#6c757d';   // unknown   - grey
					return $row->subscription_start_date." => ".$row->subscription_end_date."<br>Plan:&nbsp;<span style='font-size:13px;font-weight:600;color:{$color};'>".$difMonth. " Months</span>";
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
				
				->rawColumns(['action','name','simage','package','date','status','period'])
				->make(true);

  }
    
	
   public function export(Request $request)
	{
		$byCourse=$request->searchByCourse;
		$byYear=$request->searchByYear;
		$search=$request->search;
		$plan=$request->searchPlan;   //3, 6, 12 months

		return Excel::download(new PackageSubscriptionListExport($byCourse,$byYear,$search,$plan), 'subscription_list.csv', ExcelType::CSV);
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