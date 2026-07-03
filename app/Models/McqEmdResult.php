<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqEmdResult extends Model   
{
 
	use HasFactory;
	  
	//easy,Medium,Difficult questions details 
	  
	protected $table = 'mcq_emd_results';  
	 
    protected $fillable = [
        'subject_id','mcq_question_paper_id','student_id',
		'easy_total','easy_correct','easy_wrong','easy_skip','medium_total','medium_correct','medium_wrong',
		'medium_skip','difficult_total','difficult_correct','difficult_wrong','difficult_skip',
    ];
	
	protected $primaryKey = 'id';
	
	protected $hidden=['created_at','updated_at'];
	
	
}
