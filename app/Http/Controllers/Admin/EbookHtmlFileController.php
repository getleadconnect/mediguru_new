<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\VideoImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\EbookHtmlFile;
use App\Models\Ebook;

use Validator;
use Session;
use DataTables;

class EbookHtmlFileController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$ebts=(new Ebook())->getEbooks();  
	return view('admin.e_books.view_html_files',compact('ebts'));
  }
 
 
  public function store(Request $request)
	{
				
		$validate=Validator::make($request->all(),EbookHtmlFile::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new EbookHtmlFile())->addEbookHtmlFile($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Html file successfully added.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Details missing 1111, try again.');
				$res=0;
			}				
			//return redirect('class_videos');
			return $res;
	}
	
	public function edit($id)
	{
		$ebts=(new Ebook())->getEbooks();  
		$eb=(new EbookHtmlFile())->getEbookHtmlFileById($id);
		return view('admin.e_books.edit_html_file',compact('ebts','eb'));
	}
		
	public function update_html_file(Request $request)
	{

		$validate=Validator::make($request->all(),EbookHtmlFile::EDIT_RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		$result=(new EbookHtmlFile())->updateEbookHtmlFile($request);
		
		if($result)
		{
			Session::flash('message', 'success#Html file successfully updated.');
		}
		else
		{
			Session::flash('message', 'danger#Details missing, try again.');
		}				

		return redirect('ebook_files');
	}
  
  
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new EbookHtmlFile())->viewEbookHtmlFiles($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','hfile'])
                    ->make(true);
        }
	}
   
  
   public function destroy($id)
	{
		
		$result=(new EbookHtmlFile())->deleteHtmlFile($id);

			if($result)
			{
				Session::flash('message', 'success#Html file successfully removed.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
				$res=0;
			}				

			return $res;
	}
	
	
}
