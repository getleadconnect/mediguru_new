<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    use HasFactory;
	
	protected $table="user_menus";
	
	protected $fillable = [
      'admin_id', 'menu_id', 'menu_group_id', 'menu_order','menu_option','menu_url',
    ];

    protected $hidden = [
        'created_at','updated_at',
    ];
	
	public function Admin()
	{
		return $this->belongsTo(Admin::class);
	}
	
	public function Menu()
	{
		return $this->belongsTo(Menu::class);
	}
	
	public function MenuGroup()
	{
		return $this->belongsTo(MenuGroup::class);
	}
	
	
	public function addAdminUserMenu($request)
	{
		$uid=$request->menu_userid;
		$mid=substr($request->menu_ids,1);
		$mids=explode(",",$mid);
		
		$result="";

		foreach($mids as $m)
		{
			$mn=Menu::with('MenuGroup')->find($m);
			$umnu=UserMenu::where('menu_id',$m)->where('admin_id',$uid)->get();

				if($umnu->isEmpty())
				{			
					$result=UserMenu::create([
					'admin_id'=>$uid,
					'menu_id'=>$mn['id'],
					'menu_group_id'=>$mn['menu_group_id'],
					'menu_order'=>$mn['menu_order'],
					'menu_option'=>$mn['menu_option'],
					'menu_url'=>$mn['menu_url'],
					]);

				}
				else
				{
					Session::flash('message', 'danger#Option already exist.');
				}
				
		}

		return $result;

	}
	
	
	
	
	
	
	
	
}
