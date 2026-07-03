<?php

namespace App\Exports;

use App\Models\Student;

use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class DiscountListExport implements FromCollection,WithHeadings
{
	//use Exportable;
		
	protected $prcode =null;
	protected $rfcode =null;
	protected $opt =null;
		
	function __construct($op,$pr,$rf)
	{
		$this->prcode=$pr;
		$this->rfcode=$rf;
		$this->opt=$op;
	}
	
	
    /**
    * @return \Illuminate\Support\Collection
    */

	  public function headings():array{
        return[
            'Id',
            'Reg_date',
			'Name',
			'Package',
            'Code',
			'Discount',
            'Amount',
            'Net_Amount',
        ];
    } 
	
    public function collection()
    {
		$prcod=$this->prcode;
		$rfcod=$this->rfcode;
		$op=$this->opt;
	
		$where=null;
		
		if($prcod!="-1"  and $op==1)
		{
			$where=['promocode'=>$prcod];
		}
		else if($rfcod!="-1" and $op==2)
		{
			$where=['referral_code'=>$rfcod];
		}
		
		$stdat=Student::select('students.*','packages.package_name','purchased_packages.promocode','purchased_packages.promocode_amount','purchased_packages.referral_code','purchased_packages.referral_amount','purchased_packages.amount','purchased_packages.net_amount')
		->Join('purchased_packages','students.id','=','purchased_packages.student_id')
		->Join('packages','purchased_packages.package_id','=','packages.id')
		->where($where)->orderBy('students.id','ASC')->get();

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
		
		return collect($data);   

	}

	
}
