<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\PackagePayment;
use App\Models\Course;

use Validator;
use Session;
use DataTables;

class PackagePaymentController extends Controller
{
      
  public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
		$crs=(new Course())->getCourses();
				
		return view('admin.payment.package_payment',compact('crs'));
  }

   public function store(Request $request)
	{
	     $result=(new PackagePayment())->addPayment($request);
		 if($result)
			{
				Session::flash('message', 'success#Package payment successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				
			
			return redirect('payments');
	}		
	
	
	  
   public function destroy($id)
	{

		$result=(new PackagePayment())->deletePayment($id);

			if($result)
			{
				Session::flash('message', 'success#Payment successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('payments');
	}
  
    public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new PackagePayment())->getPayments($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					->addColumn('selbtn',function($data)
					{
						//return '<input type="checkbox" class="sub_chk" data-id="'.$data['id'].'" style="width:20px;height:20px;" ></label>';
						return  '<button type="button" class="qselect btn btn-primary btn-sm" title="Select Question" style="padding: 5px 10px 5px 10px;"><i class="fa fa-check"></i></button>';
					})
                    ->rawColumns(['name','action'])
                    ->make(true);
        }
	}

   
   
}
