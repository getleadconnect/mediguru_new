<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\McqTestResult;
use App\Models\Student;

use Session;

class Report extends Model
{
    use HasFactory;
	
	//fucntions
			
	public function viewMcqRankList($request)
	{
		$search=$request->search;
		$qpid=$request->searchByQpaper;
				
		$rank_list=McqTestResult::select('mcq_test_results.*','students.id as stud_id','students.name','mcq_question_papers.question_paper_name')
				->leftJoin('students','mcq_test_results.student_id','=','students.id')
				->leftJoin('mcq_question_papers','mcq_test_results.mcq_question_paper_id','=','mcq_question_papers.id')
				->where('mcq_question_paper_id',$qpid)->get()->toArray();
			$last_v=0;$i=0;
			usort($rank_list,array($this,'sortByMark'));
			
				foreach ($rank_list as $m => $v) 
				{
						if ($v['score'] != $last_v)
						{
						   $i++;
						   $last_v = $v['score'];
						}
					  $rank_list[$m]['student_id'] = $v['student_id'];
					  $rank_list[$m]['rank'] = $i;
				}
	
		$data = array();
		$uData = array();
		
		$rank_list=collect($rank_list)->sortBy('rank')->toArray();
				
        if(!empty($rank_list))
        {
			foreach ($rank_list as $key=>$r)
            {
				$uData['slno'] = ++$key;
				$uData['id'] =$r['stud_id'];
				$uData['name'] =$r['name'];
				$uData['qpname'] =$r['question_paper_name'];
				$uData['tdate'] =date_create($r['test_date'])->format('d-m-Y');
				$uData['answer']=$r['answer'];
				$uData['wrong']=$r['wrong'];
				$uData['skipped']=$r['skipped'];
				$uData['mark']=$r['marks'];
				$uData['score']=$r['score'];
				$uData['rank']="<b>".$r['rank']."</b>";
						
			    $data[] = $uData;
			}
        }
		return $data;

	}

	public function sortByMark($a, $b)
	{
		$a = $a['score'];
		$b = $b['score'];

		if ($a == $b) return 0;
		return ($a > $b) ? -1 : 1;
	}


//-------------------------------------------------------------------------------

public function viewMcqStudentList($request)   //student attended test report
	{
		$search=$request->search;
		$stid=$request->searchByStid;
				
		$mtdat=McqTestResult::select('mcq_test_results.*','students.name','mcq_question_papers.question_paper_name')
				->leftJoin('students','mcq_test_results.student_id','=','students.id')
				->leftJoin('mcq_question_papers','mcq_test_results.mcq_question_paper_id','=','mcq_question_papers.id')
				->where('mcq_test_results.student_id',$stid)->get();
	
		$data = array();
		$uData = array();
		
        if(!empty($mtdat))
        {
			foreach ($mtdat as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['name'] =$r['name'];
				$uData['qpname'] =$r['question_paper_name'];
				$uData['tdate'] =date_create($r['test_date'])->format('d-m-Y');
				$uData['answer']=$r['answer'];
				$uData['wrong']=$r['wrong'];
				$uData['skipped']=$r['skipped'];
				$uData['mark']=$r['marks'];
				$uData['score']=$r['score'];
						
			    $data[] = $uData;
			}
        }
		return $data;
	}


//-------------------------------------------------------------------------------

public function viewStudentList($request)   //registred students list report
	{
		$search=$request->search;
		$s_date=$request->searchByDate;
		
		$from="";$to="";
		
		if($s_date!="")
		{
			$dt=explode("-",$s_date);
			if(count($dt)==6)
			{
				$from=trim($dt[2])."-".trim($dt[0])."-".trim($dt[1]);
				$to=trim($dt[5])."-".trim($dt[3])."-".trim($dt[4]);
			}
		}
			
		$sdt=Student::select('students.*')
			->where(function($where) use($search)
			    {
					$where->where('students.name', 'like', '%' .$search . '%')
					->orWhere('students.gender', 'like', '%' .$search . '%')
					->orWhere('students.mobile', 'like', '%' .$search . '%')
					->orWhere('students.email', 'like', '%' .$search . '%')
					->orWhere('students.state', 'like', '%' .$search . '%');
			  });
	
		if($from!="" and $to!="")
		{
			$sdt->whereBetween('reg_date', [$from, $to]);
		}
		
		$stdat=$sdt->orderBy('students.id','ASC')->get();
			
	
		$data = array();
		$uData = array();
		
        if(!empty($stdat))
        {
			foreach ($stdat as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['rdate'] =date_create($r->reg_date)->format('d-m-Y');
				$uData['name'] =$r->name;
				$uData['gender'] =$r->gender;
				$uData['dob'] =date_create($r->date_of_birth)->format('d-m-Y');
				$uData['mobile'] =$r->mobile;
				$uData['email']=$r->email;
				$uData['state']=$r->state;
						
			    $data[] = $uData;
			}
        }
		return $data;

	}


//-------------------------------------------------------------------------------

public function viewSubscriptionList($request)   //registred students list report
	{
		$search=$request->search;
		$s_date=$request->searchByDate;
		
		$from="";$to="";
		
		if($s_date!="")
		{
			$dt=explode("-",$s_date);
			if(count($dt)==6)
			{
				$from=trim($dt[2])."-".trim($dt[0])."-".trim($dt[1]);
				$to=trim($dt[5])."-".trim($dt[3])."-".trim($dt[4]);
			}
		}
			
		$sdt=Student::select('students.*','packages.package_name')
		->Join('purchased_packages','students.id','=','purchased_packages.student_id')
		->Join('packages','purchased_packages.package_id','=','packages.id')
		
			->where(function($where) use($search)
			    {
					$where->where('students.name', 'like', '%' .$search . '%')
					->orWhere('students.mobile', 'like', '%' .$search . '%')
					->orWhere('students.email', 'like', '%' .$search . '%')
					->orWhere('students.state', 'like', '%' .$search . '%');
			  });
	
		if($from!="" and $to!="")
		{
			$sdt->whereBetween('reg_date', [$from, $to]);
		}
		
		$stdat=$sdt->orderBy('students.id','ASC')->get();
			
	
		$data = array();
		$uData = array();
		
        if(!empty($stdat))
        {
			foreach ($stdat as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['rdate'] =date_create($r->reg_date)->format('d-m-Y');
				$uData['name'] =$r->name;
				$uData['pkg'] =$r->package_name;
				$uData['mobile'] =$r->mobile;
				$uData['email']=$r->email;
				$uData['state']=$r->state;
						
			    $data[] = $uData;
			}
        }
		return $data;

	}


//-------------------------------------------------------------------------------

public function viewDiscountList($request)   //registred students list report
	{
		$search=$request->search;
		$pcode=$request->searchPcode;
		$rcode=$request->searchRcode;
				
		$where=null;$op=0;
		
		if($pcode!="" and $rcode=="-1")
		{
			$where=['promocode'=>$pcode];
			$op=1;
		}
		else if($pcode=="-1" and $rcode!="")
		{
			$where=['referral_code'=>$rcode];
			$op=2;
		}
		
		$sdt=Student::select('students.*','packages.package_name','purchased_packages.promocode','purchased_packages.promocode_amount','purchased_packages.referral_code','purchased_packages.referral_amount','purchased_packages.amount','purchased_packages.net_amount')
		->Join('purchased_packages','students.id','=','purchased_packages.student_id')
		->Join('packages','purchased_packages.package_id','=','packages.id')
		->where($where)
			->where(function($where) use($search)
			  {
				$where->where('students.name', 'like', '%' .$search . '%')
				->orWhere('students.mobile', 'like', '%' .$search . '%')
				->orWhere('students.email', 'like', '%' .$search . '%')
				->orWhere('students.state', 'like', '%' .$search . '%');
			  });
		
		$stdat=$sdt->orderBy('students.id','ASC')->get();

		$data = array();
		$uData = array();
		
        if(!empty($stdat))
        {
			foreach ($stdat as $key=>$r)
            {
				$uData['id'] = ++$key;
				$uData['rdate'] =date_create($r->reg_date)->format('d-m-Y');
				$uData['name'] =$r->name;
				$uData['pkg'] =$r->package_name;
				
				if($op==1)
				{
					$uData['pcode'] =$r->promocode;
					$uData['pamt']=$r->promocode_amount;
				}
				else
				{
					$uData['pcode'] =$r->referral_code;
					$uData['pamt']=$r->referral_amount;	
				}
				
				$uData['amt']=$r->amount;
				$uData['namt']=$r->net_amount;
						
			    $data[] = $uData;
			}
        }
		return $data;

	}



		
	
}
