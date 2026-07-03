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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () 
{
	
Route::post('login', [Api\UserController::class, 'login']);	
Route::post('register_student', [Api\UserController::class, 'register_student']);	
Route::post('check_device', [Api\UserController::class, 'check_device']);	
Route::post('forgot_password', [Api\UserController::class, 'forgot_password']);	
Route::post('check_user_active', [Api\UserController::class, 'check_user_active']);
Route::post('remove_user_account', [Api\UserController::class, 'remove_user_account']);


Route::post('send_otp', [Api\OtpController::class, 'send_otp']);
Route::post('verify_otp', [Api\OtpController::class, 'verify_otp']);
Route::get('test_answer_key', [Api\McqAnswerKeyController::class, 'test_mcq_answer_key']);
Route::get('dash_live_mcq_answer_key', [Api\McqAnswerKeyController::class, 'dash_live_mcq_answer_key']);
});

Route::middleware('auth:api')->group(function () {

Route::post('get_profile', [Api\UserController::class, 'get_profile']);	
Route::post('update_profile', [Api\UserController::class, 'update_profile']);
Route::post('change_password', [Api\UserController::class, 'change_password']);		

//general
Route::get('get_states', [Api\GeneralController::class, 'get_states']);		
Route::post('get_courses', [Api\GeneralController::class, 'get_courses']);
		
Route::post('get_subjects', [Api\GeneralController::class, 'get_subjects']);
Route::post('get_lessons', [Api\GeneralController::class, 'get_lessons']);	 //chapters

Route::post('get_promocode_value', [Api\GeneralController::class, 'get_promocode_value']);
Route::post('get_referral_code_value', [Api\GeneralController::class, 'get_referral_code_value']);

Route::post('get_lesson_items', [Api\GeneralController::class, 'get_lesson_items']);
Route::post('get_lesson_items_new', [Api\GeneralController::class, 'get_lesson_items_new']);

Route::post('get_lesson_item_details', [Api\GeneralController::class, 'get_lesson_item_details']);

Route::post('get_latest_news', [Api\GeneralController::class, 'get_latest_news']);


Route::post('set_video_like_dislike', [Api\GeneralController::class, 'set_video_like_dislike']);
Route::post('set_video_feedbacks', [Api\GeneralController::class, 'set_video_feedbacks']);
Route::post('set_general_feedbacks', [Api\GeneralController::class, 'set_general_feedbacks']);

Route::post('get_notifications', [Api\GeneralController::class, 'get_notifications']);

Route::post('add_chat_messages', [Api\GeneralController::class, 'add_chat_messages']);
Route::post('get_chat_messages', [Api\GeneralController::class, 'get_chat_messages']);
Route::post('remove_chat', [Api\GeneralController::class, 'remove_chat']);
Route::post('get_new_chat_count', [Api\GeneralController::class, 'get_new_chat_count']);
Route::post('get_course_schedule', [Api\GeneralController::class, 'get_course_schedule']);
Route::post('get_subject_live_class', [Api\GeneralController::class, 'get_subject_live_class']);


//packges
//Route::post('get_packages', [Api\PackageController::class, 'get_packages']);
Route::post('get_purchased_subjects', [Api\PackageController::class, 'get_purchased_subjects']);

Route::post('purchase_package', [Api\PackageController::class, 'purchase_package']);	
Route::post('single_purchase_package', [Api\PackageController::class, 'single_purchase_package']);	
Route::post('check_package_expiry_status', [Api\PackageController::class, 'check_package_expiry_status']);	
Route::post('get_purchased_packages', [Api\PackageController::class, 'get_purchased_packages']);	
//Route::post('set_payment', [Api\PackageController::class, 'set_payment']);

//MCQ question paper and questions

Route::post('get_question_papers', [Api\McqController::class, 'get_question_papers']);
Route::post('get_questions', [Api\McqController::class, 'get_questions']);
Route::post('set_mcq_results', [Api\McqController::class, 'set_mcq_results']);
Route::post('get_mcq_results', [Api\McqController::class, 'get_mcq_results']);  // existing result analytics
Route::post('get_mcq_analytics', [Api\McqController::class, 'get_mcq_analytics']);

//MCQ test answer key

Route::post('get_live_question_papers', [Api\LiveMcqController::class, 'get_live_question_papers']);
Route::post('get_live_questions', [Api\LiveMcqController::class, 'get_live_questions']);
Route::post('set_live_mcq_results', [Api\LiveMcqController::class, 'set_live_mcq_results']);
Route::post('get_live_mcq_results', [Api\LiveMcqController::class, 'get_live_mcq_results']);  // existing result analytics
Route::post('get_live_mcq_analytics', [Api\LiveMcqController::class, 'get_live_mcq_analytics']);

Route::post('set_dash_live_mcq_results', [Api\LiveMcqController::class, 'set_dash_live_mcq_results']);
Route::post('get_dash_live_mcq_results', [Api\LiveMcqController::class, 'get_dash_live_mcq_results']);  // existing result analytics
Route::post('get_dash_live_mcq_analytics', [Api\LiveMcqController::class, 'get_dash_live_mcq_analytics']);
Route::post('get_dash_live_mock_tests', [Api\LiveMcqController::class, 'get_dash_live_mock_tests']);

Route::post('get_live_mock_tests', [Api\LiveMcqController::class, 'get_live_mock_tests']);




});


