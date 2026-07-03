<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Subject;   //it is sub-courses
use App\Models\Package; 
use App\Models\SharedSubject; 

use Validator;
use Session;
use DataTables;

class SharedSubjectController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
	//$crs = (new Course())->getCourses(); 
	return view('admin.subject.view_shared_subjects');  
  }
  
  public function store(Request $request)
	{
	}
	
	public function edit($id)
	{

	}

   public function destroy($id)
	{

		$result=SharedSubject::where('id',$id)->delete();
	
		if($result)
		{
			$res=1;
		}
		else
		{
			$res=0;
		}				

		return  $res;
	}

	
	public function viewSharedSubjects($request)
	{
		
		$search=$request->search;
		
		
		$dts=SharedSubject::select('shared_subjects.*','courses.course_name','subjects.subject_name')
		->leftJoin('courses','shared_subjects.course_id','courses.id')
		->leftJoin('subjects','shared_subjects.subject_id','subjects.id')
		->where(function($where) use($search)
			    {
					$where->where('subjects.subject_name', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%');
			  })->orderBy('shared_subjects.id','ASC')->get();
		
		$data = array();
		$udata = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {

				$udata['id'] =$r->id;
				$udata['subid'] =$r->subject_id;
				$udata['cname']=$r->course_name;
				$udata['sname']=$r->subject_name;
				$btn='<a href="javascript::void(0)" id="'.$r->id.'" class="btnDel btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>';
				$udata['action']=$btn;
				
				$data[] = $udata;
			}
        }

		return $data;
	}
	
	public function view_data(Request $request)
	{
		if ($request->ajax()) {
            $data = $this->viewSharedSubjects($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action',])
                    ->make(true);
        }
	}
	
}
