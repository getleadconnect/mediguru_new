<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CourseSchedule extends Model
{
    use HasFactory;
	
	protected $table='course_schedules';
	
    protected $fillable = [ 'course_unique_id','course_schedule',    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	public function getCourseSchedules()
	{
		$result=self::select('course_schedules.*','courses.course_name')
		->leftJoin('courses','course_schedules.course_unique_id','=','courses.unique_id')
		->orderBy('id','ASC')->get();
		return $result;
	}	
		
	public function addSchedule($request)
	{

		$result=self::create([
		'course_unique_id'=>$request->course_unique_id,
		'course_schedule'=>$request->course_schedule,
		'status'=>1
		]);
		
		return $result;
		
	}
	
	public function getCourseScheduleById($id)
	{
		$result=self::whereId($id)->orderBy('id','ASC')->first();
		return $result;
	}	
	
	public function updateSchedule($request)
	{
		
		$csh=[
		   'course_unique_id'=>$request->ed_course_unique_id,
		   'course_schedule'=>$request->ed_course_schedule,
		];
		
		$result=self::whereId($request->ed_schedule_id)->update($csh);
		return $result;
		
	}
}
