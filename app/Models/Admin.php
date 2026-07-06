<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory , HasApiTokens;
	
	protected $table='admins';
	
    protected $fillable = [
      'name','role_id','email','mobile','password','status',
    ];

    protected $hidden = [
        'password',
		'created_at',
		'updated_at',
    ];
	
	public function addAdminUser($request)
	{

		$res=self::create([
			'name'=>$request->name,
			'mobile'=>$request->mobile,
			'email'=>$request->email,
			'role_id'=>$request->role,
			'password'=>Hash::make($request->password),
			'status'=>1
			]);


		return $res;
	}

  public function updateAdminUser($request)
	{

		if(trim($request->ed_password)!="")
		{
		   $new=[
			'name'=>$request->ed_name,
			'mobile'=>$request->ed_mobile,
			'email'=>$request->ed_email,
			'role_id'=>$request->ed_role,
			'password'=>Hash::make($request->ed_password),
			];
		}
		else
		{
			$new=[
			'name'=>$request->ed_name,
			'mobile'=>$request->ed_mobile,
			'email'=>$request->ed_email,
			'role_id'=>$request->ed_role,
			];
		}
		
		$res=self::where('id',$request->auserid)->update($new);
		return $res;
		
	}
	
	
	public function deleteAdminUser($id)
	{
		return self::find($id)->delete();
	}
		
	public function getAdminUsers($request)
	{
		
		$search=$request->search;
		
		$dts=self::select('admins.*','roles.role_name')
		->leftJoin('roles','admins.role_id','=','roles.id')
		->where('admins.role_id','!=',1)
		->where(function($where) use($search)
			    {
					$where->where('admins.name', 'like', '%' .$search . '%')
					->orWhere('admins.email', 'like', '%' .$search . '%')
					->orWhere('admins.mobile', 'like', '%' .$search . '%');
			  })->orderBy('admins.id','ASC')->get();
		
		$data = array();
		$uData = array();
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
				if($r->status==1)
				$st='<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>';
				else 
				$st='<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>';
			
				$um=UserMenu::where('admin_id',$r->id)->first();
				if(empty($um))
				{
					$setm='<a href="'.url('set_menus/'.$r->id).'" class="btn btn-primary btn-sm kt-margin-l-30"><i class="la la-plus"></i> Set Menu</a>';
				}
				else
				{
					$setm='<span class="kt-badge kt-badge--warning kt-badge--md"><i class="la la-check"></i></span>&nbsp;&nbsp;<a href="'.url('set_menus/'.$r->id).'" class="btn btn-info btn-sm"><i class="la la-plus"></i> Reset Menu</a>';
				}
		
			
			    $uData['id'] = $r->id;
				$uData['name']=$r->name;
				$uData['mobile']=$r->mobile;
				$uData['email']=$r->email;
				$uData['role']=$r->role_name;
				$uData['smenu']=$setm;
				$uData['status']=$st;
				
				$btn='<a href="#" id="'.$r->id.'" class="edit btn bt-primary btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>&nbsp;
					  <a href="'.url('delete_admin_user').'/'.$r->id.'" id="conf" class="btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				if($r->status==1)
					  $btn.='<a href="'.url('deactivate_admin').'/'.$r->id.'" class="btn bt-warning btn-secondary btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_admin').'/'.$r->id.'" class="btn bt-success btn-secondary btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				$uData['action']=$btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	
}
