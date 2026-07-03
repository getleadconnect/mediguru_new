<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\McqResultExport;
use App\Exports\McqResultStudent;
use App\Exports\StudentListExport;
use App\Exports\SubscriptionListExport;
use App\Exports\DiscountListExport;

use App\Models\Course;
use App\Models\Report;
use App\Models\Promocode;
use App\Models\Staff;

use Validator;
use Session;
use DataTables;

use App\Models\McqQuestionPaper;


class ReportController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs=(new Course())->getCourses();
	return view('admin.reports.mcq_rank_wise_report',compact('crs'));
  }
    
  public function view_data(Request $request)
	{
		
	  if ($request->ajax()) {
          $data = $data = (new Report())->viewMcqRankList($request);
          return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['rank'])
                ->make(true);
        }
	}
	 	
	public function export_mcq_rank_list($qpid)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new McqResultExport($qpid), 'mcq_test_rank_list.xlsx');
    }
	
//-------------------------------- student wise report ---------------------------------------------------------
	
	
 public function mcq_student_wise_report()
  {
	$crs=(new Course())->getCourses();
	return view('admin.reports.mcq_student_wise_report',compact('crs'));
  }
  
  public function view_student_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = $data = (new Report())->viewMcqStudentList($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    //->rawColumns(['rank'])
                    ->make(true);
        }
	}
	
  public function export_mcq_student_list($stid)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new McqResultStudent($stid), 'mcq_test_student_wise_list.xlsx');
    }
	
//-------------------------------- student wise report ---------------------------------------------------------
	
	
 public function student_list_report()
  {
	$crs=(new Course())->getCourses();
	return view('admin.reports.students_list_report',compact('crs'));
  }
  
  public function view_student_list(Request $request)
	{
		
		if ($request->ajax()) {
            $data = $data = (new Report())->viewStudentList($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    //->rawColumns(['rank'])
                    ->make(true);
        }
	}
	
  public function export_student_list($fdt)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new StudentListExport($fdt), 'student_list.xlsx');
    }
	
//-----------------------------------------------------------------------------------------------	
	
 public function subscription_list_report()
  {
	$crs=(new Course())->getCourses();
	return view('admin.reports.subscription_list_report',compact('crs'));
  }
  
  public function view_subscription_list(Request $request)
	{
		
		if ($request->ajax()) {
            $data = $data = (new Report())->viewSubscriptionList($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
	}
	
  public function export_subscription_list($fdt)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new SubscriptionListExport($fdt), 'subscription_list.xlsx');
    }
	
//-----------------------------------------------------------------------------------------------		
	
 public function discount_list_report()
  {
	$pcod=(new Promocode())->getPromocodes();
	$sta=(new Staff())->getReferralCodes();
	return view('admin.reports.discount_report',compact('pcod','sta'));
  }
  
  
 public function view_discount_list(Request $request)
  {
	  if($request->ajax())
	  {
          $data = $data = (new Report())->viewDiscountList($request);
          return DataTables::of($data)
			->addIndexColumn()
            ->make(true);
       }
 }

  public function export_discount_list($op,$pr,$ref)
	{
		 //return Excel::download($export, 'test.xlsx');
        return Excel::download(new DiscountListExport($op,$pr,$ref), 'discount_list.xlsx');
    }
	
//-----------------------------------------------------------------------------------------------		
	
	
}