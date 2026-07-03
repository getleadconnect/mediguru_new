<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//chat api ------------------------
Route::post('admin_user_login', [Api\v2\UserController::class, 'admin_user_login']);
Route::post('admin_get_chat_messages', [Api\v2\GeneralController::class, 'admin_get_chat_messages']);
Route::post('admin_remove_chat', [Api\v2\GeneralController::class, 'admin_remove_chat']);
Route::post('add_admin_chat_message', [Api\v2\GeneralController::class, 'add_admin_chat_message']);
Route::get('admin_chat_students', [Api\v2\GeneralController::class, 'admin_chat_students']);

//---------------------------------

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
	
Route::post('login', [Api\v2\UserController::class, 'login']);	
Route::post('register_student', [Api\v2\UserController::class, 'register_student']);	
Route::post('check_device', [Api\v2\UserController::class, 'check_device']);	
Route::post('forgot_password', [Api\v2\UserController::class, 'forgot_password']);	
Route::post('check_user_active', [Api\v2\UserController::class, 'check_user_active']);
Route::post('remove_user_account', [Api\v2\UserController::class, 'remove_user_account']);

Route::post('send_otp', [Api\v2\OtpController::class, 'send_otp']);
Route::post('verify_otp', [Api\v2\OtpController::class, 'verify_otp']);
Route::get('test_answer_key', [Api\v2\McqAnswerKeyController::class, 'test_mcq_answer_key']);
Route::get('dash_live_mcq_answer_key', [Api\v2\McqAnswerKeyController::class, 'dash_live_mcq_answer_key']);
});

Route::middleware('auth:api')->group(function () {

Route::post('get_profile', [Api\v2\UserController::class, 'get_profile']);	
Route::post('update_profile', [Api\v2\UserController::class, 'update_profile']);
Route::post('change_password', [Api\v2\UserController::class, 'change_password']);		

//general
Route::get('get_states', [Api\v2\GeneralController::class, 'get_states']);		
Route::post('get_courses', [Api\v2\GeneralController::class, 'get_courses']);
		
Route::post('get_subjects', [Api\v2\GeneralController::class, 'get_subjects']);
Route::post('get_lessons', [Api\v2\GeneralController::class, 'get_lessons']);	 //chapters

Route::post('get_promocode_value', [Api\v2\GeneralController::class, 'get_promocode_value']);
Route::post('get_referral_code_value', [Api\v2\GeneralController::class, 'get_referral_code_value']);

Route::post('get_lesson_items', [Api\v2\GeneralController::class, 'get_lesson_items']);
Route::post('get_lesson_items_new', [Api\v2\GeneralController::class, 'get_lesson_items_new']);

Route::post('get_lesson_item_details', [Api\v2\GeneralController::class, 'get_lesson_item_details']);

Route::post('get_latest_news', [Api\v2\GeneralController::class, 'get_latest_news']);


Route::post('set_video_like_dislike', [Api\v2\GeneralController::class, 'set_video_like_dislike']);
Route::post('set_video_feedbacks', [Api\v2\GeneralController::class, 'set_video_feedbacks']);
Route::post('set_general_feedbacks', [Api\v2\GeneralController::class, 'set_general_feedbacks']);

Route::post('get_notifications', [Api\v2\GeneralController::class, 'get_notifications']);

Route::post('add_chat_messages', [Api\v2\GeneralController::class, 'add_chat_messages']);
Route::post('get_chat_messages', [Api\v2\GeneralController::class, 'get_chat_messages']);
Route::post('remove_chat', [Api\v2\GeneralController::class, 'remove_chat']);


Route::post('get_new_chat_count', [Api\v2\GeneralController::class, 'get_new_chat_count']);
Route::post('get_course_schedule', [Api\v2\GeneralController::class, 'get_course_schedule']);
Route::post('get_subject_live_class', [Api\v2\GeneralController::class, 'get_subject_live_class']);

//packges
//Route::post('get_packages', [Api\v2\PackageController::class, 'get_packages']);
Route::post('get_purchased_subjects', [Api\v2\PackageController::class, 'get_purchased_subjects']);

Route::post('purchase_package', [Api\v2\PackageController::class, 'purchase_package']);	
Route::post('single_purchase_package', [Api\v2\PackageController::class, 'single_purchase_package']);	
Route::post('check_package_expiry_status', [Api\v2\PackageController::class, 'check_package_expiry_status']);	
Route::post('get_purchased_packages', [Api\v2\PackageController::class, 'get_purchased_packages']);	

Route::post('payment_capture', [Api\v2\PackageController::class, 'payment_capture']);
Route::post('generate_bills', [Api\v2\PackageController::class, 'generate_invoice_pdf']);


//MCQ question paper and questions

Route::post('get_question_papers', [Api\v2\McqController::class, 'get_question_papers']);
Route::post('get_questions', [Api\v2\McqController::class, 'get_questions']);
Route::post('set_mcq_results', [Api\v2\McqController::class, 'set_mcq_results']);
Route::post('get_mcq_results', [Api\v2\McqController::class, 'get_mcq_results']);  // existing result analytics
Route::post('get_mcq_analytics', [Api\v2\McqController::class, 'get_mcq_analytics']);

//MCQ test answer key

Route::post('get_live_question_papers', [Api\v2\LiveMcqController::class, 'get_live_question_papers']);
Route::post('get_live_questions', [Api\v2\LiveMcqController::class, 'get_live_questions']);
Route::post('set_live_mcq_results', [Api\v2\LiveMcqController::class, 'set_live_mcq_results']);
Route::post('get_live_mcq_results', [Api\v2\LiveMcqController::class, 'get_live_mcq_results']);  // existing result analytics
Route::post('get_live_mcq_analytics', [Api\v2\LiveMcqController::class, 'get_live_mcq_analytics']);

Route::post('set_dash_live_mcq_results', [Api\v2\LiveMcqController::class, 'set_dash_live_mcq_results']);
Route::post('get_dash_live_mcq_results', [Api\v2\LiveMcqController::class, 'get_dash_live_mcq_results']);  // existing result analytics
Route::post('get_dash_live_mcq_analytics', [Api\v2\LiveMcqController::class, 'get_dash_live_mcq_analytics']);
Route::post('get_dash_live_mock_tests', [Api\v2\LiveMcqController::class, 'get_dash_live_mock_tests']);

Route::post('get_live_mock_tests', [Api\v2\LiveMcqController::class, 'get_live_mock_tests']);

Route::get('/email_bill', [Admin\BillEmailController::class,'index']);  //testing function
Route::get('/bill_email', [Admin\BillEmailController::class,'send_bill_to_mail']);  //testing function
Route::get('/generate-pdf', [Admin\PDFController::class,'generate_pdf']); //testing function


Route::get('get_ebook_titles', [Api\v2\EbookController::class, 'get_ebook_titles']);
Route::post('get_ebook_files', [Api\v2\EbookController::class, 'get_ebook_files']);


});


