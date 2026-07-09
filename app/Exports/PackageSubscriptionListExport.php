<?php

namespace App\Exports;

use App\Models\PurchasedPackage;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithHeadings;
//use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class PackageSubscriptionListExport implements FromCollection,WithHeadings
{
	//use Exportable;

	protected $flt_date =null;
	protected $byYear=null;
	protected $search=null;
	protected $plan=null;
	protected $byCourse=null;

	function __construct($byCourse,$byYear,$search,$plan)
	{
		$this->byCourse=$byCourse;
		$this->byYear=$byYear;
		$this->search=$search;
		$this->plan=$plan;
	}


    /**
    * @return \Illuminate\Support\Collection
    */

	  public function headings():array{
        return[
            'Id',
            'Reg_date',
			'Name',
            'Mobile',
            'Email',
			'State',
			'Course',
			'Package',
			'Period(Start->End)',
			'Plan',
        ];
    }

    public function collection()
    {
		$byCourse=$this->byCourse;
		$byYear=$this->byYear;
		$search=$this->search;
		$plan=$this->plan;

		$qry=PurchasedPackage::query();

		$qry->select('purchased_packages.*','students.name','students.mobile','students.email','students.state','packages.package_name','courses.course_name')
				->leftJoin('students','purchased_packages.student_id','=','students.id')
				->leftJoin('packages','purchased_packages.package_id','=','packages.id')
				->leftJoin('courses','packages.course_unique_id','=','courses.unique_id')
				->where(function($where) use($search)
			    {
					$where->where('students.name', 'like', '%' .$search . '%')
					->orWhere('students.mobile', 'like', '%' .$search . '%')
					->orWhere('courses.course_name', 'like', '%' .$search . '%')
					->orWhere('packages.package_name', 'like', '%' .$search . '%')
					->orWhere('purchased_packages.created_at', 'like', '%' .$search . '%');
			  });

		if($byCourse!="")
			$qry->where('packages.course_unique_id','=',$byCourse);
		if($byYear!="")
			$qry->whereYear('purchased_packages.created_at',$byYear);

		//filter by plan (3, 6, 12 months) - based on month difference of subscription start & end date
		if($plan!="")
			$qry->whereRaw('TIMESTAMPDIFF(MONTH, purchased_packages.subscription_start_date, purchased_packages.subscription_end_date) = ?',[$plan]);

		$pkgData=$qry->orderBy('purchased_packages.id','DESC')->get();

		$data = array();

        if(!empty($pkgData))
        {
			foreach ($pkgData as $key=>$r)
            {
				$difMonth='';
				$expired='--';
				if($r->subscription_start_date!="" and $r->subscription_end_date!="")
					$difMonth=Carbon::parse($r->subscription_start_date)->diffInMonths(Carbon::parse($r->subscription_end_date));

				if($r->subscription_end_date<date('Y-m-d'))
					$expired="Expired";

				$uData=array();
				$uData['id'] = ++$key;
				$uData['rdate'] = $r->created_at!="" ? date_create($r->created_at)->format('d-m-Y') : "";
				$uData['name'] = $r->name;
				$uData['mobile'] = $r->mobile;
				$uData['email'] = $r->email;
				$uData['state'] = $r->state;
				$uData['course'] = $r->course_name;
				$uData['pkg'] = $r->package_name;
				$uData['period'] = $r->subscription_start_date." => ".$r->subscription_end_date;
				$uData['plan'] = $difMonth." Months";
				$uData['Status'] = $expired;

			    $data[] = $uData;
			}
        }

		return collect($data);
    }


}
