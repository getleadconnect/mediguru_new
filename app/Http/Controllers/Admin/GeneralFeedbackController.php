<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

//it is sub-courses
use App\Models\GeneralFeedback;

use Validator;
use Session;
use DataTables;

class GeneralFeedbackController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	return view('admin.general_feedbacks.view_general_feedbacks');
  }
    
  
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new GeneralFeedback())->viewGeneralFeedbacks($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
        }
	}
   
  
   public function destroy($id)
	{

		$result=(new GeneralFeedback())->deleteGeneralFeedback($id);

			if($result)
			{
				Session::flash('message', 'success#Feedback successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('general_feedbacks');
	}
	
	
	
}
