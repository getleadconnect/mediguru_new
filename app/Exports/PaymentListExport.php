<?php

namespace App\Exports;

use App\Models\PackagePayment;
use App\Models\Package;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class PaymentListExport implements FromCollection,WithHeadings
{
	//use Exportable;

	protected $dRange =null;
	protected $byYear=null;
	protected $search=null;
	protected $byCourse=null;

	function __construct($drange,$byCourse,$byYear,$search)
	{
		$this->dRange=$drange;
		$this->byCourse=$byCourse;
		$this->byYear=$byYear;
		$this->search=$search;
	}


    /**
    * @return \Illuminate\Support\Collection
    */

	  public function headings():array{
        return[
            'Id',
            'Date',
			'Name',
			'Mobile',
			'Email',
            'Course',
            'Package',
			'Package Rate',
			'Promo_Value',
			'Referral_Value',
			'Net Amount',
        ];
    }

    public function collection()
    {
		$byCourse=$this->byCourse;
		$byYear=$this->byYear;
		$search=$this->search;
		$d_Range=$this->dRange;

		$from="";$to="";
		if($d_Range!="" and $d_Range!="0")
		{
			$dt=explode("-",$d_Range);
			if(count($dt)==6)
			{
				$from=trim($dt[2])."-".trim($dt[0])."-".trim($dt[1]);
				$to=trim($dt[5])."-".trim($dt[3])."-".trim($dt[4]);
			}
		}

		$dts=PackagePayment::query();
		$dts->select('package_payments.*','students.name','students.mobile','students.email','courses.course_name')
		->leftJoin('students','package_payments.student_id','=','students.id')
		//->leftJoin('packages','package_payments.package_id','=','packages.id')
		->leftJoin('courses','package_payments.course_unique_id','=','courses.unique_id')
		->where(function($where) use($search)
			{
				$where->where('students.name', 'like', '%' .$search . '%')
				->orWhere('students.mobile', 'like', '%' .$search . '%')
				->orWhere('courses.course_name', 'like', '%' .$search . '%')
				->orWhere('package_payments.package_rate', 'like', '%' .$search . '%')
				->orWhere('package_payments.net_amount', 'like', '%' .$search . '%');
			});
		
		if($byCourse!="")
		{
			$dts->where('package_payments.course_unique_id',$byCourse);
		}
		if($byYear!=null){
			$dts->whereYear('package_payments.created_at',$byYear);
		}
		if($from!="" and $to!="")
		{
			$dts->whereBetween('package_payments.created_at',[$from,$to]);
		}
		
		$dats=$dts->orderBy('package_payments.id','ASC')->get();
		
		if(!empty($dats))
        {
			foreach ($dats as $r)
            {
				$pkg_na='';
				if(strpos($r->package_id,',')!=false)
				{
					$pkid=explode(",",$r->package_id);
					
					$pna=Package::whereIn('id',$pkid)->get();
					foreach($pna as $r1)
					{
						$pkg_na.=",●-".$r1->package_name;
					}
					
					$pkg_na=substr($pkg_na,1);
				}
				else
				{
					$pna=Package::where('id',$r->package_id)->first();
					$pkg_na=(!empty($pna))?$pna->package_name:'';
				}
    			
			    $uData['id'] = $r->id;
				$uData['date'] =date_create($r->created_at)->format('d-m-Y');
				$uData['name'] =strtoupper($r->name);
				$uData['mobile'] =$r->mobile;
				$uData['email'] =$r->email;
				$uData['course'] =$r->course_name;
				$uData['package'] =$pkg_na;
				$uData['prate'] =$r->package_rate;
				$uData['pvalue'] =$r->promocode_value;
				$uData['rvalue'] =$r->referral_value;
				$uData['netamt'] =$r->net_amount;

			    $data[] = $uData;
			}
        }

		return collect($data);
    }

}
