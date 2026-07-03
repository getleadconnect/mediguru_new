<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

use App\Models\Admin;
use App\Models\User;
use App\Models\Student;
use App\Models\PurchasedPackage;
use App\Models\McqQuestionPaper;
use App\Models\McqTestResult;
use App\Models\McqTestAllResult;
use App\Models\McqQuestion;
use App\Models\Course;

use App\Models\Subject;
use App\Models\DashboardBanner;
use App\Models\Package;
use App\Models\PackagePayment;

use Carbon\Carbon;

use Session;
use Validator;
use DataTables;

class DashboardController extends Controller
{
  use AuthenticatesUsers;
  
  protected $guard = 'admin';
    
  public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
	{
		
		$stcount=[];
		
		
		$stcount['stud_count']=Student::count();
		$stcount['subs_count']=PurchasedPackage::select('student_id')->distinct()->count();   //subscriptions
		$stcount['user_count']=User::where('status',1)->distinct()->count();   //subscriptions
		
		//today,weekly,monthly,yearly
		
		$stcount['td_count']= Student::whereDate('created_at', Carbon::today())->count();  
		$stcount['wek_count'] = Student::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
		$stcount['mon_count']=Student::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
		$stcount['yr_count']= Student::whereYear('created_at', date('Y'))->count();
		
		//subscriptions
		
		$stcount['tds_count']= PurchasedPackage::whereDate('created_at', Carbon::today())->count();
		$stcount['weks_count'] = PurchasedPackage::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
		$stcount['mons_count']= PurchasedPackage::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
		$stcount['yrs_count']= PurchasedPackage::whereYear('created_at', date('Y'))->count();

		//payments / revenue

		$stcount['pay_count']  = PackagePayment::where('status',1)->count();
		$stcount['revenue']    = (float) PackagePayment::where('status',1)->sum('net_amount');

		$stcount['td_rev']  = (float) PackagePayment::where('status',1)->whereDate('created_at', Carbon::today())->sum('net_amount');
		$stcount['wek_rev'] = (float) PackagePayment::where('status',1)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('net_amount');
		$stcount['mon_rev'] = (float) PackagePayment::where('status',1)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('net_amount');
		$stcount['yr_rev']  = (float) PackagePayment::where('status',1)->whereYear('created_at', date('Y'))->sum('net_amount');


		$qpaper_count=McqQuestionPaper::count();

		//for chart : active course-wise subscribed students count------------
		// label = courses.unique_id , value = distinct students with an
		// active subscription (status=1 & subscription_end_date in future)
		// matched via purchased_packages.course_unique_id = courses.unique_id

		$courses = Course::where('status',1)->orderBy('id','desc')->limit(15)->get();

		$dat1=[];

		foreach($courses as $key=>$c)
		{
			$st_cnt = PurchasedPackage::where('course_unique_id',$c->unique_id)
						->where('status',1)
						->whereDate('subscription_end_date','>',date('Y-m-d'))
						->distinct('student_id')
						->count('student_id');

			$dat1[]=[
				'y'=>$c->unique_id,
				'a'=>$st_cnt,
			];
		}

		$dat=json_encode($dat1);
		//---------------------------------

		return view('admin.dashboard.dashboard',compact('dat','stcount','qpaper_count'));
	}

  //TO CHANGE ADMIN PASSWORD
  
	public function change_password(Request $request)
	{

		$dat=['password'=>Hash::make($request->new_pass)];
		$res=Admin::where('id',$request->aid)->update($dat);

		return $res;

	}









}
