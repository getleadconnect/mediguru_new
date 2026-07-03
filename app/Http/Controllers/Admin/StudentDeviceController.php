<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\StudentDevice;
use App\Models\State;

use Validator;
use Session;
use DataTables;

class StudentDeviceController extends Controller
{
    
	public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	 $state=State::orderBy('id','ASC')->get();
    return view('admin.student.student_device',compact('state'));
	
  }

   public function destroy($id)
	{

		$result=(new StudentDevice())->deleteStudentDevice($id);

			if($result)
			{
				Session::flash('message', 'success#Student Device successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('student_devices');
	}
	
    public function view_data(Request $request)
	{
		$state=$request->searchByState;
		if($state!="")
		{
			Session::put(['sd_state'=>$state]);  
		}
		else
		{
			$subid=Session::get('sd_state');
		}
		
		if ($request->ajax()) {
            $data = (new StudentDevice())->getStudentDevices($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
                    ->rawColumns(['action','sname'])
                    ->make(true);
        }
	}
	
	
	
}
