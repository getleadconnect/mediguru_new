<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserHiddenCourse extends Model
{
    use HasFactory;
	
	protected $table='user_hidden_courses';
	
    protected $fillable = [ 'student_id','course_unique_id',    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	public function getUserAssignedHiddenCourses()
	{
		$result=self::select('user_hidden_courses.*','students.name','courses.course_name')
		->leftJoin('students','user_hidden_courses.student_id','=','students.id')
		->leftJoin('courses','user_hidden_courses.course_unique_id','=','courses.unique_id')->get();
		return $result;
	}	
	
	
	
}
