<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Menu;
use App\Models\UserMenu;
use App\Models\MenuGroup;

use Validator;
use Session;
use DataTables;

class MenuController extends Controller
{
    
 public function __construct()
  {
      $this->middleware('admin');
  }
  
 	 
  public function index()
    {
		
		$id=Session::get('menu_user_id');
		
		if(empty($id))
		{
			return redirect('admin_users');
		}
		
		$auser=Admin::find($id);
		$mnus=UserMenu::with('MenuGroup')->where('admin_id',$id)->get();
		return view('admin.menus.set_menu',compact('mnus','auser'));
    }
	
	public function set_menu($id)  //for reset menus
    {
		$menus=Menu::all();
		$auserid=Session::get('menu_user_id');
		$u=UserMenu::select('menu_id')->where('admin_id','=',$auserid)->get('menu_id')->toArray();
		Session::put(['menu_user_id'=>$id]);
		return redirect('menus');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
		  $result=(new UserMenu())->addAdminUserMenu($request);
		  
		  if($result)
			{
				Session::flash('message', 'success#Admin user menu successfully added.');
			}
			else
			{
				Session::flash('message', 'danger#Something wrong, try again.');
			}		

	  return redirect()->back();
	
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try
		{
			$um = UserMenu::find($id);
			$value = $um->delete();			

			if($value)
			{
			  Session::flash('message', 'success#User menu successfully removed!'); 
			}
			else
			{
				Session::flash('message', 'danger#Please try again.!'); 
			}

		}
		catch(Exception $e)	{	}

		return redirect('menus'); 
    }
	
    
	   /**
     * view the menu details.
     * * @param  int  $id
     * @return \Illuminate\Http\Response
     */
		
	
	public function view_menu(Request $request)
	{
			
		if ($request->ajax()) {
            $data = (new Menu())->getMenus($request);
            return DataTables::of($data)
                    ->addIndexColumn()

                    ->rawColumns(['check','action'])
                    ->make(true);
        }
	}
		
	
	public function set_menu_confirm($id)
	{
		echo '
			<input type="hidden"  name="menu_userid" value="'.Session::get('menu_user_id').'">
			<input type="hidden" name="menu_ids" value="'.$id.'">
			<div class="form-group row" style="padding-left:50px;">
			<label class="col-xl-12 col-lg-12 text-left" style="font-size:18px">To set selected menu items to user?</label>
			</div>
		';
	}
	
	
}
