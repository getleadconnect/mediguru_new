<?php

namespace App\Imports;

use App\Models\Student;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

	//protected $subject_id =null;
		

	function __construct()
	{

	}

    public function model(array $row)
    {
		$id=new Student([
			'reg_date'=>$row['reg_date'],
			'name'=>$row['name'],
			'gender'=>$row['gender'],
			'date_of_birth'=>$row['date_of_birth'],
			'mobile'=>$row['mobile'],
			'email'=>$row['email'],
			'state'=>$row['state'],
			'student_image'=>$row['student_image'],
			'package_status'=>$row['package_status'],
			'status'=>$row['status'],
		]);
		
		dd($id);
	}


}
