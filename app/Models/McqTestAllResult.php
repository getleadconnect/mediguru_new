<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Session;

class McqTestAllResult extends Model
{
	use HasFactory;
	  
	protected $table = 'mcq_test_all_results';  
	 
    protected $fillable = [
        'subject_id','mcq_question_paper_id','student_id','result_date','question_id','question_mode','question_type','correct_answer','answer',
    ];
	
	protected $primaryKey = 'id';
	
	protected $hidden=['created_at','updated_at'];
		
	
	
	public function get_attendees_list($request)  //dashboard analytics
	{

		$search=$request->search;
		$qid=$request->quest_id;

		$dts=self::select('mcq_test_all_results.*','students.name')
		->leftJoin('students','mcq_test_all_results.student_id','=','students.id')
		->where('question_id',$qid)
		->where(function($where) use($search)
			    {
					$where->where('mcq_test_all_results.answer', 'like', '%' .$search . '%')
					->orWhere('students.name', 'like', '%' .$search . '%');
			  })->orderBy('mcq_test_all_results.id','ASC')->get();
		
		
		$data = array();
		
		
		$sdata = array();
		$cdata = array();
		$wdata = array();

        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
			    $sans = array();
				$cans = array();
				$wans = array(); 
				
				if($r->answer==NUll or $r->answer=="")
				{
				$sans['id'] = $r->id;
				$sans['sname'] =$r->name;
				$sans['answer'] =$prem='<span class="kt-badge kt-badge--info  " >-</span>';

				}
				else if($r->correct_answer==$r->answer and $r->answer!="")
				{
				$cans['id'] = $r->id;
				$cans['sname'] =$r->name;
				$cans['answer'] =$prem='<span class="kt-badge kt-badge--success "><i class="fas fa-check"></i></span>';

				}
				else if($r->correct_answer!=$r->answer and $r->answer!="")
				{
				$wans['id'] = $r->id;
				$wans['sname'] =$r->name;
				$wans['answer'] =$prem='<span class="kt-badge kt-badge--danger" ><i class="fas fa-times"></i></span>';

				}
				
			   if(!empty($cans)){$cdata[] = $cans;}
			   if(!empty($wans)){$wdata[] = $wans;}
			   if(!empty($sans)){$sdata[] = $sans;}
			}
			
			if(!empty($cdata))	{  $data=array_merge($data,$cdata);  }
			
			if(!empty($wdata)) 	{  $data=array_merge($data,$wdata);  }
			
			if(!empty($sdata))	{  $data=array_merge($data,$sdata);  }
			
        }
	
		return $data;
	}
	
	
	public function get_attendees_total($qid)  //dashboard analytics
	{
		$dts=self::select('mcq_test_all_results.*','students.name')
		->leftJoin('students','mcq_test_all_results.student_id','=','students.id')
		->where('question_id',$qid)
		->get();
		
		$c=0;$w=0;$s=0;
		
        if(!empty($dts))
        {
			foreach ($dts as $r)
            {
			    $sans = array();
				$cans = array();
				$wans = array(); 
				
				if($r->answer==NUll or $r->answer=="")
				{
				$s++;
				}
				else if($r->correct_answer==$r->answer and $r->answer!="")
				{
				$c++;
				}
				else if($r->correct_answer!=$r->answer and $r->answer!="")
				{
				$w++;
				}
			}
		}
			$tot=$c.",".$w.",".$s;
		return $tot;
	}
	
	
}
