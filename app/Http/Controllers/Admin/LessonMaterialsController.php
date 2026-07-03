<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Imports\VideoImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Material;
use App\Models\LessonMaterial;
use App\Models\Course;
use App\Models\Subject;

use Validator;
use Session;
use DataTables;

class LessonMaterialsController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	$crs= (new Course())->getCourses(); 
	$sub= (new Subject())->getSubjects();  
	return view('admin.lesson_items.lesson_materials',compact('crs','sub'));
  }
 	
 public function view_all_lesson_materials()
  {
	$sub= (new Subject())->getSubjects();  
	return view('admin.lesson_items.view_lesson_materials',compact('sub'));
  }
	
	
  public function store(Request $request)
   {
		   $result=(new LessonMaterial())->addLessonMaterial($request);
		   
			if($result)
			{
				Session::flash('message', 'success#Video successfully added.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Details missing, try again.');
				$res=0;
			}				

			//return redirect('class_videos');
			return $res;
	}
	
	public function view_all_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonMaterial())->viewAllLessonMaterials($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					
					->rawColumns(['status','action','micon','dat'])
                    ->make(true);
        }
	}
	
	public function get_material_data($uid)
	{
		$mdat=Material::where('unique_id',$uid)->first();
		$dat="";
		if(!empty($mdat))
		{
			$dat=$mdat->material_data;
		}
		
		return view('admin.lesson_items.get_material_data',compact('dat'));
	}
	
	//---------------------------------------------------------
	
   public function view_data(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonMaterial())->viewMaterials($request);
            return DataTables::of($data)
                    ->addIndexColumn()
					->addColumn('selbtn',function($data)
					{
						//return '<input type="checkbox" class="sub_chk" data-id="'.$data['id'].'" style="width:20px;height:20px;" ></label>';
						return  '<button type="button" class="mselect btn btn-primary btn-sm" title="Add Video" style="padding: 5px 5px 5px 10px;"><i class="fa fa-plus"></i></button>';
					})
                    ->rawColumns(['selbtn'])
                    ->make(true);
        }
	}
	
	
	public function get_lesson_materials(Request $request)
	{

		if ($request->ajax()) {
            $data = (new LessonMaterial())->LessonMaterials($request);
            return DataTables::of($data)
				->addIndexColumn()
				
				->rawColumns(['icon','action','dat','ord'])
				->make(true);
        }
	}
   
   public function add_material_order_no(Request $request)
	{
		$new=['order_no'=>$request->order_no];
		$result=LessonMaterial::where('id',$request->mitem_id)->update($new);

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
  
   public function destroy($id)
	{

		$result=(new LessonMaterial())->deleteLessonMaterial($id);

			if($result)
			{
				Session::flash('message', 'success#Material successfully removed.');
				$res=1;
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
				$res=0;
			}				

			//return redirect('video_lessions');
			return $res;
	}
	
	
	
	
}
