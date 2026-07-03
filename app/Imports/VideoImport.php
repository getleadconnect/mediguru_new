<?php

namespace App\Imports;

use App\Models\VimeoVideo;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VideoImport implements ToModel,WithHeadingRow   //vimeo videos 
{
   
   /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

	protected $course_id =null;
		

	function __construct($crsid)
	{
   	   $this->course_id=$crsid;
	}

    public function model(array $row)
    {
        if($row['video_id']!="")
		{
			return new VimeoVideo([
			  'course_id'=>$this->course_id,
			  'video_id'=>$row['video_id'],
			  'video_title'=>$row['video_title'],
			  'description'=>$row['description'],	
			]);
		}

    }

}
