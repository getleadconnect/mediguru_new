<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqRankList extends Model
{
	
	use HasFactory;
	  
	protected $table = 'mcq_rank_list';  
	 
    protected $fillable = [
		'subject_id','mcq_question_paper_id','student_id','test_date','answer','wrong',
		'skipped','mark','negative','score','status'
    ];
	
	protected $primaryKey = 'id';
	
	protected $hidden=['created_at','updated_at'];
	
	
	
	
	
	
}
