<?php

namespace App\Exports;

use App\Models\Student;

use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubscriptionListExport implements FromCollection,WithHeadings
{
	//use Exportable;
		
	protected $flt_date =null;
		

	function __construct($fdate)
	{
		$this->flt_date=$fdate;
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
            'Mobile',
            'Email',
            'State',
        ];
    } 
	
    public function collection()
    {
		$s_date=$this->flt_date;
		$from="";$to="";
		
		if($s_date!="" and $s_date!="0")
		{
			$dt=explode("-",$s_date);
			if(count($dt)==6)
			{
				$from=trim($dt[2])."-".trim($dt[0])."-".trim($dt[1]);
				$to=trim($dt[5])."-".trim($dt[3])."-".trim($dt[4]);
			}
		}
			
		$sdt=$sdt=Student::select('students.*','packages.package_name')
		->Join('purchased_packages','students.id','=','purchased_packages.student_id')
		->Join('packages','purchased_packages.package_id','=','packages.id');
	
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

		return collect($data);   

		//return McqTestResult::all();
    }

	
}
