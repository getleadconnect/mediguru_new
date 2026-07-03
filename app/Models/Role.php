<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

	protected $table='roles';
	
    protected $fillable = [
      'role_name','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	//fucntions

	public function addRole($request)
	{
		   $res=self::create([
			'role_name'=>$request->role_name,
			'status'=>1
			]);
		return $res;
	}
	
	public function getRoles()
	{
		$data=self::where('id','!=',1)->orderBy('id','ASC')->get();
		return $data;
	}

	public function getRoleById($id)
	{
		$data=self::find($id);
		return $data;
	}
	
}
