<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuOption extends Model
{
    use HasFactory;
	
	protected $table='menu_options';
	
    protected $fillable = [
      'menu_group','menu_option',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];

	public function getMenuOptions()
	{
		$data=self::orderBy('id','ASC')->get();
		return $data;
	}
	
	public function deleteMenuOption($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}
	
	
	
}
