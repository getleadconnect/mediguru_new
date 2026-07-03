<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;

use Validator;
use Session;
use App\Models\Promocode;
use App\Models\EbookTitle;
use App\Models\User;
use DataTables;

class EbookTitleController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	  return view('admin.e_books.ebook_title');
  }
    
  public function store(Request $request)
	{

		$validate=Validator::make($request->all(),EbookTitle::RULES);
		
		if($validate->fails())
		{
			$res=0;
		}

		   $result=(new EbookTitle())->addEbookTitle($request);
		   
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
		$ebt=(new EbookTitle())->getEbookTitleById($id);
		return view('admin.e_books.edit_ebook_title',compact('ebt'));
	}
		
	public function update_ebook_title(Request $request)
	 {

		$validate=Validator::make($request->all(),EbookTitle::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}
		
		$result=(new EbookTitle())->updateEbookTitle($request);

			if($result)
			{
				Session::flash('message', 'success#Promocode successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('ebook_title');
	}
		
	public function view_data(Request $request)
	{
		 if ($request->ajax()) {
            $data = (new EbookTitle())->viewEbookTitles();
            return DataTables::of($data)
                ->addIndexColumn()
			
                ->rawColumns(['action'])
                ->make(true);
        }
	}
  
   public function destroy($id)
	{

		$result=(new EbookTitle())->deleteEbookTitle($id);
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
