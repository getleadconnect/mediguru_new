<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;

use Validator;
use Session;
use App\Models\Ebook;
use DataTables;

class EbookController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	  return view('admin.e_books.ebook');
  }
    
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),Ebook::RULES);
		
		if($validate->fails())
		{
			$res=0;
		}

		   $result=(new Ebook())->addEbook($request);
		   
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
	
	public function edit($id)
	{
		$eb=(new Ebook())->getEbookById($id);
		return view('admin.e_books.edit_ebook',compact('eb'));
	}
		
	public function update_ebook(Request $request)
	 {

		$validate=Validator::make($request->all(),Ebook::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new Ebook())->updateEbook($request);

			if($result)
			{
				Session::flash('message', 'success#Ebook successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('ebooks');
	}
		
	public function view_data(Request $request)
	{
		 if ($request->ajax()) {
            $data = (new Ebook())->viewEbooks();
            return DataTables::of($data)
                ->addIndexColumn()
			
                ->rawColumns(['action','eimg'])
                ->make(true);
        }
	}
  
   public function destroy($id)
	{

		$result=(new Ebook())->deleteEbook($id);
		Session::flash('message', 'success#'.$result);
		
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
	
	
}
