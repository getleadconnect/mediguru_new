<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use DB;
use Log;
use Session;

class RemovedStudent extends Model
{
    use HasFactory;
	
	protected $table='removed_students';
	
    protected $fillable = [
      'student_id','name','gender','date_of_birth','mobile','email','state','student_image','package_status','status',
    ];

	protected $primaryKey='id';
	
    protected $hidden = [
        'created_at',
		'updated_at',
    ];
	
	public function getStudentById($id)
	{
		$data=self::select('removed_students.*')
		->where('removed_students.id',$id)->first();
		return $data;
	}
	
	public function getStudentsByCourseUniqueId($uid)
	{
		$data=self::select('removed_students.*')
		->leftJoin('purchased_packages','removed_students.student_id','=','purchased_packages.student_id')
		->where('purchased_packages.course_unique_id',$uid)->get();
		return $data;
	}

	
}
