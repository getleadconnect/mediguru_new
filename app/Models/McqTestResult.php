<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqTestResult extends Model
{
 
	use HasFactory;
	  
	protected $table = 'mcq_test_results';  
	 
    protected $fillable = [
        'subject_id','mcq_question_paper_id','student_id','test_date','total_questions','answer','wrong','skipped',
		'marks','negative','score','total_time','status',
    ];
	
	protected $primaryKey = 'id';
	
	protected $hidden=['created_at','updated_at'];
	
	
}
