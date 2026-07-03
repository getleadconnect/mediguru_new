<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
	
	protected $table="menus";
	
	protected $fillable = [
       'menu_group_id', 'menu_option','menu_url','menu_order','status'
    ];

    protected $hidden = [

    ];
	
	public function MenuGroup()
	{
		return $this->belongsTo(MenuGroup::class);
	}
		
	public function getMenus($request)
	{
		
		$search=$request->search;
		
		$menu=self::select('menus.*','menu_groups.menu_group_name')
			->leftJoin('menu_groups','menus.menu_group_id','=','menu_groups.id')
			->where('status','1')->orderBy('id','ASC')->get();
		
		$data = array();
		$uData = array();
		
		
		$auserid=session('menu_user_id');
		$udt=UserMenu::select('menu_id')->where('admin_id','=',$auserid)->get('menu_id')->toArray();
		
        if(!empty($menu))
        {
            foreach ($menu as $key=>$r)
            {
				
				$key ='"'.array_search($r->id, array_column($udt, 'menu_id')).'"';

				if($key=='""')
				{	$sel="";	}
				else 	
				{	$sel= '&nbsp;&nbsp;&nbsp;<span style="font-size:16px;color:green;font-weight:600;"><i class="la la-check"></i></span>';  }
				
				$uData['check'] =" <span><input type='checkbox' class='sub_chk' style='width:20px;height:20px;' data-id='".$r->id."'>" .$sel."</span>";
				
				$uData['id'] = $r->id;
				$uData['mgroup'] = $r->menu_group_name;
                $uData['moption'] = $r->menu_option;
				$data[] = $uData;
			}
        }

		return $data;
	}
	
	
	
	
}
