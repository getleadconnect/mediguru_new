<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

use DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 
	protected $table="users";
	
    protected $fillable = [
        'student_id','mobile','email','password','status'
		];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
		'created_at',
		'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
		
	
	public function addUser($request,$stid)
	{
		return self::create([
		
			'student_id'=>$stid,
			'mobile'=>$request->mobile,
			'email'=>$request->email,
			'password'=>Hash::make($request->password),
			'status'=>1
		]);
		
	}
	
	
	public function updateStudentUser($request)
	{
		
		$stid=$request->ed_student_id;
		$uid=$request->ed_user_id;
		
		$pass=trim($request->ed_password);
				
		$result="";
		DB::beginTransaction();
        try{
		
		if($pass=="")
		{
			$dat=['mobile'=>$request->ed_mobile,'email'=>$request->ed_email];
		}
		else
		{
			$dat=['mobile'=>$request->ed_mobile,'email'=>$request->ed_email,'password'=>Hash::make($pass)];
		}
		
		$new=['mobile'=>$request->ed_mobile,'email'=>$request->ed_email];
		
		$result=self::whereId($uid)->update($dat);
		$res=Student::where('id',$stid)->update($new);
        DB::commit();
		}
		catch(\Exception $e)
		{
			//\Log::info($e);
			$result=0;
			DB::rollback();
		}
		
		return $result;
	}
	
	
	
	public function getUsers($request)
	{
		
		$search=$request->search;
		//$scrs=$request->searchByCourse;
		//$sscrs=$request->searchBySCourse;
		
		$dts=self::select('users.*','students.name')
		->leftJoin('students','users.student_id','=','students.id')
		->where(function($where) use($search)
			    {
					$where->where('users.mobile', 'like', '%' .$search . '%')
					->orWhere('users.email', 'like', '%' .$search . '%')
					->orWhere('students.name', 'like', '%' .$search . '%');
			  })->orderBy('users.id','ASC')->get();
		
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
				
								
			    $uData['id'] = $r->id;
				$uData['sname']=$r->name;
				$uData['mobile']=$r->mobile;
				$uData['email']=$r->email;
				$uData['status']=$st;
				
				$btn='<a href="javascript:void();" id="'.$r->id.'" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>
					  <a href="'.url('delete_user').'/'.$r->id.'" id="conf" class=" btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;'; 
				if($r->status==1)
					  $btn.='<a href="'.url('deactivate_user').'/'.$r->id.'" class="edit btn btn-warning btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a>'; 	
				else
					 $btn.='<a href="'.url('activate_user').'/'.$r->id.'" class="edit btn btn-success btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a>'; 	
				
				$uData['action']=$btn;
						
			    $data[] = $uData;
			}
        }

		return $data;
	}
	
	
	public function getUserById($id)
	{
		return self::find($id)->first();
	}
	
	public function getAllUsers()
	{
		return self::select('users.id as user_id','students.name')
		->leftJoin('students','users.student_id','=','students.id')
		->where('users.status',1)->get();
	}
	
		
	public function deleteUser($id)
	{
		return self::find($id)->delete();
	}
		
	
}
