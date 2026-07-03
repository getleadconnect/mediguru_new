<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class GeneralFeedback extends Model
{
    use HasFactory;
	
	protected $table='general_feedbacks';
	
    protected $fillable = [
      'name','mobile','feedbacks',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];

	public function addGeneralFeedback($request)  
	{
		return self::create([
			'name'=>$request->name,
			'mobile'=>$request->mobile,
			'feedbacks'=>$request->feedback,
		]);
	}
	
	public function viewGeneralFeedbacks($request)
	{

		$search=$request->search;
		$searchDF=$request->searchDateFrom;
		$searchDT=$request->searchDateTo;

		$dts=self::select('general_feedbacks.*')
				->where(function($where) use($search)
				{
					$where->where('general_feedbacks.name', 'like', '%' .$search . '%')
					->orWhere('general_feedbacks.mobile', 'like', '%' .$search . '%')
					->orWhere('general_feedbacks.feedbacks', 'like', '%' .$search . '%');
				});
		
		if($searchDF!="" and $searchDT!="")
		{
			$dts->whereBetween('created_at',[$searchDF,$searchDT]);
		}
		
		$dats=$dts->orderBy('general_feedbacks.id','ASC')->get();
		
		$data = array();
		$uData = array();
				
        if(!empty($dats))
        {
			foreach ($dats as $key=>$r)
            {
				$mt='';

				$action='<a href="'.url('delete_general_feedback').'/'.$r->id.'" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a>&nbsp;';
				
			    $uData['id'] = ++$key;
				$uData['name'] = $r->name;
				$uData['mob'] = $r->mobile;
				$uData['fbak'] =$r->feedbacks;
				$uData['action'] =$action;

			    $data[] = $uData;
			}
        }

		return $data;
	}
	
public function deleteGeneralFeedback($id)
	{
		$result=self::find($id)->delete();
		return $result;
	}



	
}
