<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\ChatData;
use App\Models\Course;

use Validator;
use Session;
use DataTables;

class ChatController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
  public function index()
  {
    $studs = (new ChatData())->getChatStudents(); 
	$crs = (new Course())->getCourses(); 
	$no=ChatData::count();
	Session::put(['chat_no'=>$no]);
	return view('admin.chat.chat',compact('studs','crs'));
  }

  public function get_chat_messages($id)
  {
	  $dat=(new ChatData())->getStudentChatMessages($id);
	  return $dat;
  }
  
  
  public function store(Request $request)
	{

		   $result=(new ChatData())->addAdminMessage($request);
		   
			if($result)
			{
				
				$res=true;
			}
			else
			{
				
				$res=false;
			}				

			return $res;
	}
	
	
	public function add_image(Request $request)
	{

		   $result=(new ChatData())->addImage($request);
		   
			if($result!='')
			{
				
				$res=$result;
			}
			else
			{
				
				$res=false;
			}				

			return $res;
	}
		
	
	
	public function view_data(Request $request)
	{
		
		if ($request->ajax()) {
            $data = (new ChatData())->viewChatStudents($request);
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['studs'])
                    ->make(true);
        }
	}
	
	
	public function remove_chat_message($id)
	{

		$result=(new ChatData())->deleteChatMessageById($id);
		  
		if($result)
		{
			$res=true;
		}
		else
		{
			$res=false;
		}				
		return $res;
		
	}
	
	
	
	

	
	
}
