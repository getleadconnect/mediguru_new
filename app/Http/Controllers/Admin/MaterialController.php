<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\VideoImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Course;
use App\Models\Subject;   //it is sub-courses
use App\Models\Material;

use Validator;
use Session;
use DataTables;

class MaterialController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
    
	$crs = (new Course())->getCourses(); 
	//$sub = (new Subject())->getSubjects(); 
	return view('admin.materials.view_materials',compact('crs'));
  }
  
  
  public function add_materials()
  {
	$crs = (new Course())->getCourses(); 
	return view('admin.materials.add_materials',compact('crs'));
  }
 	
	public function store(Request $request)
	{
		
		//dd($request);
		
		$validate=Validator::make($request->all(),Material::RULES);
		
		if($validate->fails())
		{
			Session::flash('message', 'danger#Details missing, try again.');
			return back()->withErrors($validate)->withInput();
		}

		   $result=(new Material())->addMaterials($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Material successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('add_materials');
			//return $res;
	}
	
	public function edit($id)
	{
		$mat=(new Material())->getMaterialById($id);
		return view('admin.materials.edit_material',compact('mat'));
	}
	
	
	public function update_material(Request $request)
	{

		$result=(new Material())->updateMaterial($request);

			if($result)
			{
				Session::flash('message', 'success#Material successfully updated.');
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
			}				

			return redirect('materials');
	}
	
	
	public function view_material_data($id)
	{
		$dat=Material::where('id',$id)->first();
		return view('admin.materials.view_material_data',compact('dat'));
	}
  
  
  
  
   public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new Material())->viewMaterials($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action','micon','mdata','status'])
                    ->make(true);
        }
	}
   
  
   public function destroy($id)
	{

		$result=(new Material())->deleteMaterial($id);

			if($result)
			{
				Session::flash('message', 'success#Material successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('materials');
	}
	
public function activate($id)
	{

		$res=['status'=>1];
		
		$result=Material::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Material successfully removed.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('materials');
	}
	
	
	public function deactivate($id)
	{

		$res=['status'=>0];
		
		$result=Material::whereId($id)->update($res);
		
			if($result)
			{
				Session::flash('message', 'success#Material successfully deactivated.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}				

			return redirect('materials');
	}
	
	
}
