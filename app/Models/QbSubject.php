<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class QbSubject extends Model   //question bank subjects
{
    use HasFactory;
	
	protected $table='qb_subjects';
	
    protected $fillable = [
      'subject_name','status',
    ];

    protected $hidden = [
        'created_at',
		'updated_at',
    ];
		
	//fucntions
	
	public const RULES=[
	'no_of_subject'=>'required',
	];
	
	
	public const EDIT_RULES=[
	'ed_subject_name'=>'required',
	];
		
	public function addQbSubject($request)
	{
		
		$nos=$request->no_of_subject;
		$subs=$request->subject;
		foreach($subs as $s)
		{
			$res= self::create([
				'subject_name'=>Str::upper($s),
				'status'=>1
			]);
		}
		return $res;
	}
		
	public function updateQbSubject($request)
	{

		$id=$request->ed_subject_id;

		$dat=[
		'subject_name'=>Str::upper($request->ed_subject_name),
		'status'=>1
		];
		
		$result=self::whereId($id)->update($dat);
		return $result;
	}
	
	public function getQbSubjects()
	{
		$data=self::select('qb_subjects.*')->orderBy('id','ASC')->get();
		return $data;
	}
		
	public function getQbSubjectById($id)
	{
		$data=self::findorfail($id);
		return $data;
	}

	public function deleteQbSubject($id)
	{
		$dat=self::find($id);
		$result=$dat->delete();
		return $result;
	}

}
