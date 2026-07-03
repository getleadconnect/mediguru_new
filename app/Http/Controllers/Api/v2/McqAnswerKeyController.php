<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class McqAnswerKeyController extends Controller
{
    /**
	 * Function test_mcq_answer_key
	 * Function to display mock test answer key (web view link)
	   http://mediguru.bcompetitive.in/api/test_answer_key?student_id=4&subject_id=1&qpaper_id=1
	   http://mediguru.bcompetitive.in/api/dash_live_mcq_answer_key?student_id=3&qpaper_id=27
	 
	 * @param student_id,subject_id,qpaper_id (int)
	 * return [ web view of answer key]
	 */
		
	public function test_mcq_answer_key()
	{
		 return view('admin.answerkey.pdf_answer_key');
	}


	public function dash_live_mcq_answer_key()
	{
		 return view('admin.answerkey.dash_live_pdf_answer_key');
	}
	


	//----------------------------------
		
		
}
