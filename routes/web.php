<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin;
use App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function ()
{
	return redirect('login');
});

Route::get('/support', function ()
{
	return view('support');
});

Route::get('/privacy_policy', function () {
    return view('privacy_policy');
});


Route::get('/login', [Admin\LoginController::class,'show_Login_Form'])->name('admin.login');
Route::post('login', [Admin\LoginController::class,'login']);
Route::post('logout', [Admin\LoginController::class,'logout'])->name('admin.logout');
Route::get('logout', [Admin\LoginController::class,'logout']);
Route::get('/delete_account', [Admin\LoginController::class,'delete_account']);
Route::post('/delete_user_account', [Admin\LoginController::class,'delete_user_account']);

Route::resource('/dashboard', Admin\DashboardController::class);
Route::post('change_password', [Admin\DashboardController::class,'change_password']);

Route::resource('/menus', Admin\MenuController::class);
Route::get('/set_menus/{id}', [Admin\MenuController::class,'set_menu']);
Route::get('/view_menu', [Admin\MenuController::class, 'view_menu']);
Route::get('/set_menu_confirm/{id}', [Admin\MenuController::class,'set_menu_confirm']);
Route::get('/delete_menu/{id}', [Admin\MenuController::class,'destroy']);


Route::get('/question_attendees', [Admin\AnalyticsController::class,'index']); //for analytics
Route::get('/view_qpaper_questions', [Admin\AnalyticsController::class,'view_qpaper_questions']); //for analytics
Route::get('/get_question_papers/{id}', [Admin\AnalyticsController::class,'get_question_papers']); //for analytics
Route::get('/get_attendees', [Admin\AnalyticsController::class,'get_attendees']); //for analytics
Route::get('/get_attendees_total/{id}', [Admin\AnalyticsController::class,'get_attendees_total']); //for analytics

//dashboard Bnner
Route::resource('/banners', Admin\DashboardBannerController::class);
Route::get('/edit_banner/{id}', [Admin\DashboardBannerController::class,'edit']);
Route::post('/update_banner', [Admin\DashboardBannerController::class,'update_banner']);
Route::get('/delete_banner/{id}', [Admin\DashboardBannerController::class,'destroy']);
Route::get('/activate_banner/{id}', [Admin\DashboardBannerController::class,'activate']);
Route::get('/deactivate_banner/{id}', [Admin\DashboardBannerController::class,'deactivate']);

//Course routes
Route::resource('/courses', Admin\CourseController::class);
Route::post('/add_course', [Admin\CourseController::class,'store']);
Route::get('/edit_course/{id}', [Admin\CourseController::class,'edit']);
Route::post('/update_course', [Admin\CourseController::class,'update_course']);
Route::get('/delete_course/{id}', [Admin\CourseController::class,'destroy']);
Route::get('/activate_course/{id}', [Admin\CourseController::class,'activate']);
Route::get('/deactivate_course/{id}', [Admin\CourseController::class,'deactivate']);

Route::get('/get_course_features/{id}', [Admin\CourseController::class,'get_course_features']);
Route::get('/assign_hidden_course', [Admin\CourseController::class,'assign_hidden_course']);
Route::post('/course_assign_to_user', [Admin\CourseController::class,'course_assign_to_user']);  //hidden course
Route::get('/delete_user_hidden_course/{id}', [Admin\CourseController::class,'delete_user_hidden_course']);  //hidden course
Route::get('/course_schedule', [Admin\CourseController::class,'course_schedule']);  
Route::post('/save_course_schedule', [Admin\CourseController::class,'save_course_schedule']);  
Route::get('/edit_course_schedule/{id}', [Admin\CourseController::class,'edit_course_schedule']);  
Route::post('/update_course_schedule', [Admin\CourseController::class,'update_course_schedule']); 
Route::get('/delete_course_schedule/{id}', [Admin\CourseController::class,'delete_course_schedule']); 
Route::get('/view_course_schedule_by_id/{id}', [Admin\CourseController::class,'view_course_schedule_by_id']); 
Route::get('/get_course_subscription_end_date/{id}', [Admin\CourseController::class,'get_course_subscription_end_date']); 
//Route::get('/get_rank/{id}', [Admin\CourseController::class,'get_rank']);  //just for test

Route::get('/get_course_for_reorder', [Admin\CourseController::class,'get_course_for_reorder']);
Route::post('/set_course_reorder', [Admin\CourseController::class,'set_course_reorder']);

//subject routes
Route::resource('/subjects', Admin\SubjectController::class);
Route::get('/edit_subject/{id}', [Admin\SubjectController::class,'edit']);
Route::post('/update_subject', [Admin\SubjectController::class,'update_subject']);
Route::get('/delete_subject/{id}', [Admin\SubjectController::class,'destroy']);

Route::get('/view_subjects', [Admin\SubjectController::class,'view_data']);

Route::get('/activate_subject/{id}', [Admin\SubjectController::class,'activate']);
Route::get('/deactivate_subject/{id}', [Admin\SubjectController::class,'deactivate']);
Route::get('/get_subjects_by_course_id/{id}', [Admin\SubjectController::class,'get_subjects_by_course_id']);
Route::get('/get_subjects_by_course_unique_id/{id}', [Admin\SubjectController::class,'get_subjects_by_course_unique_id']);

Route::get('/reorder_subjects', [Admin\SubjectController::class,'reorder_subjects']);
Route::get('/get_subjects_for_reorder/{id}', [Admin\SubjectController::class,'get_subjects_for_reorder']);
Route::post('/set_subjects_reorder', [Admin\SubjectController::class,'set_subjects_reorder']);
Route::get('/subject_detail_for_copy/{id}', [Admin\SubjectController::class,'get_subject_detail_for_copy']);
Route::post('/copy_subject_to_course', [Admin\SubjectController::class,'copy_subject_to_course']);



//shared subjects
Route::resource('/shared_subjects', Admin\SharedSubjectController::class);
Route::get('/delete_shared_subject/{id}', [Admin\SharedSubjectController::class,'destroy']);
Route::get('/view_shared_subjects', [Admin\SharedSubjectController::class,'view_data']);


//lesson routes
Route::resource('/lessons', Admin\LessonController::class);
Route::get('/edit_lesson/{id}', [Admin\LessonController::class,'edit']);
Route::post('/update_lesson', [Admin\LessonController::class,'update_lesson']);
Route::get('/delete_lesson/{id}', [Admin\LessonController::class,'destroy']);
Route::get('/view_lessons', [Admin\LessonController::class,'view_data']);
Route::get('/get_lessons_by_subject_id/{id}', [Admin\LessonController::class,'get_lessons_by_subject_id']);
Route::get('/activate_deactivate_lesson/{id}/{op}', [Admin\LessonController::class,'activate_deactivate']);

//Common Fucntions
Route::post('/save_subject', [Admin\CommonFunctionController::class,'save_subject']);
Route::post('/save_lesson', [Admin\CommonFunctionController::class,'save_lesson']);

//like-dislike Fucntions
Route::resource('/like_dislikes', Admin\LikeDislikeController::class);
Route::get('/view_like_dislikes', [Admin\LikeDislikeController::class,'view_data']);
Route::get('/delete_like_dislike/{id}', [Admin\LikeDislikeController::class,'destroy']);

//comments Functions
Route::resource('/comments', Admin\CommentsController::class);
Route::get('/view_comments', [Admin\CommentsController::class,'view_data']);
Route::get('/delete_comment/{id}', [Admin\CommentsController::class,'destroy']);

//general feedbacks
Route::resource('/general_feedbacks', Admin\GeneralFeedbackController::class);
Route::get('/view_general_feedbacks', [Admin\GeneralFeedbackController::class,'view_data']);
Route::get('/delete_general_feedback/{id}', [Admin\GeneralFeedbackController::class,'destroy']);

//video lesson routes
Route::resource('/videos', Admin\VideosController::class);
Route::post('/save_video', [Admin\VideosController::class,'store']);
Route::get('/edit_video/{id}', [Admin\VideosController::class,'edit']);
Route::post('/update_video', [Admin\VideosController::class,'update_video']);
Route::get('/delete_video/{id}', [Admin\VideosController::class,'destroy']);
Route::get('/view_videos', [Admin\VideosController::class,'view_data']);

//lesson Items routes
Route::resource('/lesson_videos', Admin\LessonVideosController::class);
Route::post('/set_lesson_video', [Admin\LessonVideosController::class,'store']);
Route::get('/delete_lesson_video/{id}', [Admin\LessonVideosController::class,'destroy']);
Route::get('/view_lesson_videos', [Admin\LessonVideosController::class,'view_data']);
Route::get('/get_lesson_videos', [Admin\LessonVideosController::class,'get_lesson_videos']);
Route::get('/view_all_lesson_videos', [Admin\LessonVideosController::class,'view_all_lesson_videos']);
Route::get('/view_all_videos', [Admin\LessonVideosController::class,'view_all_videos']);
Route::post('/add_order_no', [Admin\LessonVideosController::class,'add_order_no']);

//lesson materials routes
Route::resource('/lesson_materials', Admin\LessonMaterialsController::class);
Route::post('/set_lesson_material', [Admin\LessonMaterialsController::class,'store']);
Route::get('/delete_lesson_material/{id}', [Admin\LessonMaterialsController::class,'destroy']);
Route::get('/view_lesson_materials', [Admin\LessonMaterialsController::class,'view_data']);
Route::get('/get_lesson_materials', [Admin\LessonMaterialsController::class,'get_lesson_materials']);
Route::get('/view_all_lesson_materials', [Admin\LessonMaterialsController::class,'view_all_lesson_materials']);
Route::get('/view_all_materials', [Admin\LessonMaterialsController::class,'view_all_data']);
Route::get('/get_material_data/{id}', [Admin\LessonMaterialsController::class,'get_material_data']);
Route::post('/add_material_order_no', [Admin\LessonMaterialsController::class,'add_material_order_no']);

//lesson mcq tests
Route::resource('/lesson_mcq_tests', Admin\LessonMcqTestController::class);
Route::post('/set_lesson_mcq_test', [Admin\LessonMcqTestController::class,'store']);
Route::get('/delete_lesson_mcq_test/{id}', [Admin\LessonMcqTestController::class,'destroy']);
Route::get('/view_lesson_mcq_tests', [Admin\LessonMcqTestController::class,'view_data']);
Route::get('/get_lesson_mcq_tests', [Admin\LessonMcqTestController::class,'get_lesson_mcq_tests']);
Route::get('/view_lesson_mcq_qpapers', [Admin\LessonMcqTestController::class,'view_lesson_mcq_qpapers']);
Route::get('/view_lesson_qpapers', [Admin\LessonMcqTestController::class,'view_lesson_qpapers']);
Route::post('/add_mcq_qpaper_order_no', [Admin\LessonMcqTestController::class,'add_mcq_qpaper_order_no']);

//lesson live tests
Route::resource('/lesson_live_tests', Admin\LessonLiveTestController::class);
Route::post('/set_lesson_live_test', [Admin\LessonLiveTestController::class,'store']);
Route::get('/delete_lesson_live_test/{id}', [Admin\LessonLiveTestController::class,'destroy']);
Route::get('/view_lesson_live_tests', [Admin\LessonLiveTestController::class,'view_data']);
Route::get('/get_lesson_live_tests', [Admin\LessonLiveTestController::class,'get_lesson_live_tests']);
Route::get('/view_lesson_live_qpapers', [Admin\LessonLiveTestController::class,'view_lesson_live_qpapers']);
Route::get('/view_lesson_qpapers', [Admin\LessonLiveTestController::class,'view_lesson_qpapers']);
Route::post('/add_live_test_order_no', [Admin\LessonLiveTestController::class,'add_live_test_order_no']);

//class videos routes
Route::resource('/class_videos', Admin\ClassVideosController::class);
Route::post('/save_videos', [Admin\ClassVideosController::class,'store']);
Route::get('/edit_class_video/{id}', [Admin\ClassVideosController::class,'edit']);
Route::post('/update_class_video', [Admin\ClassVideosController::class,'update_class_video']);
Route::get('/delete_class_video/{id}', [Admin\ClassVideosController::class,'destroy']);
Route::get('/activate_class_video/{id}', [Admin\ClassVideosController::class,'activate']);
Route::get('/deactivate_class_video/{id}', [Admin\ClassVideosController::class,'deactivate']);
Route::get('/view_class_videos', [Admin\ClassVideosController::class,'view_data']);
Route::get('/get_vimeo_videos_by_course_id/{id}', [Admin\ClassVideosController::class,'get_vimeo_videos_by_course_id']);

//class materials routes
Route::resource('/materials', Admin\MaterialController::class);
Route::get('/add_materials', [Admin\MaterialController::class,'add_materials']);
Route::post('/save_materials', [Admin\MaterialController::class,'store']);
Route::get('/view_material_data/{id}', [Admin\MaterialController::class,'view_material_data']);
Route::get('/edit_material/{id}', [Admin\MaterialController::class,'edit']);
Route::post('/update_material', [Admin\MaterialController::class,'update_material']);
Route::get('/delete_material/{id}', [Admin\MaterialController::class,'destroy']);
Route::get('/activate_material/{id}', [Admin\MaterialController::class,'activate']);
Route::get('/deactivate_material/{id}', [Admin\MaterialController::class,'deactivate']);
Route::get('/view_materials', [Admin\MaterialController::class,'view_data']);


/*//Import Videos routes
Route::resource('/import_videos', Admin\ImportVideosController::class);
Route::get('/edit_vimeo_video/{id}', [Admin\ImportVideosController::class,'edit']);
Route::post('/update_video', [Admin\ImportVideosController::class,'update_video']);
Route::get('/view_vimeo_videos', [Admin\ImportVideosController::class,'view_data']);
Route::post('/import_from_excel', [Admin\ImportVideosController::class,'import_from_excel']);
Route::get('/delete_vimeo_video/{id}', [Admin\ImportVideosController::class,'destroy']);
*/

//Question bank - subject routes
Route::resource('/qb_subjects', Admin\QbSubjectController::class);
Route::get('/edit_qb_subject/{id}', [Admin\QbSubjectController::class,'edit']);
Route::post('/update_qb_subject', [Admin\QbSubjectController::class,'update_qb_subject']);
Route::get('/delete_qb_subject/{id}', [Admin\QbSubjectController::class,'destroy']);

//MCQ question papers

/*Route::resource('/question_papers', Admin\QuestionPaperController::class);
Route::get('/add_question_papers', [Admin\QuestionPaperController::class,'add_question_paper']);
Route::post('/save_question_paper', [Admin\QuestionPaperController::class,'store']);
Route::get('/edit_question_paper/{id}', [Admin\QuestionPaperController::class,'edit']);
Route::post('/update_question_paper', [Admin\QuestionPaperController::class,'update_question_paper']);
Route::get('/delete_qpaper/{id}', [Admin\QuestionPaperController::class,'destroy']);
Route::get('/activate_qpaper/{id}', [Admin\QuestionPaperController::class,'activate']);
Route::get('/deactivate_qpaper/{id}', [Admin\QuestionPaperController::class,'deactivate']);
Route::get('/view_question_papers', [Admin\QuestionPaperController::class,'view_data']);
*/

//MCQ question papers

Route::resource('/mcq_question_papers', Admin\McqQuestionPaperController::class);
Route::get('/add_mcq_qpapers', [Admin\McqQuestionPaperController::class,'add_mcq_qpaper']);
Route::post('/save_mcq_qpaper', [Admin\McqQuestionPaperController::class,'store']);
Route::get('/edit_mcq_qpaper/{id}', [Admin\McqQuestionPaperController::class,'edit']);
Route::post('/update_mcq_qpaper', [Admin\McqQuestionPaperController::class,'update_question_paper']);
Route::get('/delete_mcq_qpaper/{id}', [Admin\McqQuestionPaperController::class,'destroy']);
Route::get('/activate_mcq_qpaper/{id}', [Admin\McqQuestionPaperController::class,'activate']);
Route::get('/deactivate_mcq_qpaper/{id}', [Admin\McqQuestionPaperController::class,'deactivate']);
Route::get('/view_mcq_question_papers', [Admin\McqQuestionPaperController::class,'view_data']);


//MCQ question papers

Route::resource('/live_question_papers', Admin\LiveQuestionPaperController::class);
Route::post('/save_live_qpaper', [Admin\LiveQuestionPaperController::class,'save_live_qpaper']);
Route::get('/edit_live_question_paper/{id}', [Admin\LiveQuestionPaperController::class,'edit']);
Route::post('/update_live_question_paper', [Admin\LiveQuestionPaperController::class,'update_live_question_paper']);
Route::get('/get_lmt_subjects_by_course_id/{id}', [Admin\LiveQuestionPaperController::class,'get_lmt_subjects_by_course_id']);
Route::get('/delete_live_qpaper/{id}', [Admin\LiveQuestionPaperController::class,'destroy']);
Route::get('/activate_live_qpaper/{id}', [Admin\LiveQuestionPaperController::class,'activate']);
Route::get('/deactivate_live_qpaper/{id}', [Admin\LiveQuestionPaperController::class,'deactivate']);
Route::get('/view_live_question_papers', [Admin\LiveQuestionPaperController::class,'view_live_data']);


//MCQ questions bank

Route::resource('/questions', Admin\QuestionController::class);
Route::get('/add_question', [Admin\QuestionController::class,'add_question']);
Route::post('/add_question', [Admin\QuestionController::class,'add_question']);
Route::post('/save_question', [Admin\QuestionController::class,'store']);
Route::get('/edit_question/{id}', [Admin\QuestionController::class,'edit']);
Route::post('/update_question', [Admin\QuestionController::class,'update_question']);
Route::get('/delete_question/{id}', [Admin\QuestionController::class,'destroy']);
Route::get('/view_questions', [Admin\QuestionController::class,'view_data']);
Route::get('/activate_question/{id}', [Admin\QuestionController::class,'activate']);
Route::get('/deactivate_question/{id}', [Admin\QuestionController::class,'deactivate']);
Route::get('/import_questions', [Admin\QuestionController::class,'import_questions']);
Route::post('/import_to_excel', [Admin\QuestionController::class,'import_to_excel']);

//Prepare MCQ question papers

Route::resource('/prepare_questions', Admin\PrepareQuestionController::class);
Route::get('/view_prepare_questions', [Admin\PrepareQuestionController::class,'view_data']);
Route::post('/add_pq_subject', [Admin\PrepareQuestionController::class,'add_pq_subject']);
Route::post('/save_quest_paper', [Admin\PrepareQuestionController::class,'save_question_paper']);
Route::get('/get_question_paper_by_course_id/{id}', [Admin\PrepareQuestionController::class,'get_question_paper_by_course_id']);
Route::post('/save_qpaper_questions', [Admin\PrepareQuestionController::class,'save_qpaper_questions']);
Route::get('/get_total_questions/{id}', [Admin\PrepareQuestionController::class,'get_total_questions']);
Route::get('/import_mcq_questions', [Admin\PrepareQuestionController::class,'import_questions']);
Route::post('/import_mcq_to_excel', [Admin\PrepareQuestionController::class,'import_mcq_to_excel']);

Route::get('/prepare_video_questions', [Admin\PrepareQuestionController::class,'prepare_video_questions']);
Route::get('/get_videos_by_subject_id/{id}', [Admin\PrepareQuestionController::class,'get_videos_by_subject_id']);
Route::get('/get_video_total_questions/{id}', [Admin\PrepareQuestionController::class,'get_video_total_questions']);
Route::post('/save_video_questions', [Admin\PrepareQuestionController::class,'save_video_questions']);
Route::get('/video_questions', [Admin\PrepareQuestionController::class,'video_questions']);
Route::get('/view_video_questions', [Admin\PrepareQuestionController::class,'view_video_data']);
Route::get('/delete_video_question/{id}', [Admin\PrepareQuestionController::class,'destroy']);

//MCQ questions
Route::resource('/mcq_questions', Admin\McqQuestionController::class);
Route::get('/view_mcq_questions', [Admin\McqQuestionController::class,'view_data']);
Route::get('/delete_mcqquestion/{id}', [Admin\McqQuestionController::class,'destroy']);

/*//Live MCQ questions
Route::resource('/mcq_questions', Admin\McqQuestionController::class);
Route::get('/view_mcq_questions', [Admin\McqQuestionController::class,'view_data']);
*/

//packages

Route::resource('/packages', Admin\PackageController::class);
Route::get('/course_packages', [Admin\PackageController::class,'course_packages']);
Route::post('/save_subject_package', [Admin\PackageController::class,'store']);
Route::post('/save_course_package', [Admin\PackageController::class,'save_course_package']);
Route::get('/view_subject_packages', [Admin\PackageController::class,'view_data']);
Route::get('/view_course_packages', [Admin\PackageController::class,'view_course_packages']);
Route::get('/edit_subject_package/{id}', [Admin\PackageController::class,'edit_subject_package']);
Route::get('/edit_course_package/{id}', [Admin\PackageController::class,'edit_course_package']);
Route::post('/update_subject_package', [Admin\PackageController::class,'update_subject_package']);
Route::post('/update_course_package', [Admin\PackageController::class,'update_course_package']);
Route::post('/update_group_package', [Admin\PackageController::class,'update_group_package']);
Route::get('/delete_package/{id}/{op}', [Admin\PackageController::class,'destroy']);
Route::get('/activate_package/{id}', [Admin\PackageController::class,'activate']);
Route::get('/deactivate_package/{id}', [Admin\PackageController::class,'deactivate']);
Route::get('/get_packages_by_course_unique_id/{id}', [Admin\PackageController::class,'get_packages_by_course_unique_id']);
//Route::get('/group_packages', [Admin\PackageController::class,'group_packages']);
Route::get('/edit_grp_package/{id}', [Admin\PackageController::class,'edit_grp_package']);

Route::get('/check_subject_package_exist/{id}', [Admin\PackageController::class,'check_subject_package_exist']);
Route::get('/check_course_package_exist/{id}', [Admin\PackageController::class,'check_course_package_exist']);
Route::get('/get_add_delete_subjects/{id}/{uid}', [Admin\PackageController::class,'get_add_delete_subjects']);
Route::get('/change_package_subjects/{pid}/{sids}', [Admin\PackageController::class,'change_package_subjects']);

//package payments

Route::resource('/payments', Admin\PackagePaymentController::class);
Route::get('/view_payments', [Admin\PackagePaymentController::class,'view_data']);
Route::get('/delete_payment/{id}', [Admin\PackagePaymentController::class,'destroy']);

//Students

Route::resource('/students', Admin\StudentController::class);
Route::get('/add_student', [Admin\StudentController::class,'add_student']);
Route::post('/save_student', [Admin\StudentController::class,'store']);
Route::get('/edit_student/{id}', [Admin\StudentController::class,'edit']);
Route::post('/update_student', [Admin\StudentController::class,'update_student']);
Route::get('/delete_student/{id}', [Admin\StudentController::class,'destroy']);
Route::get('/view_students', [Admin\StudentController::class,'view_data']);
Route::get('/activate_student/{id}', [Admin\StudentController::class,'activate']);
Route::get('/deactivate_student/{id}', [Admin\StudentController::class,'deactivate']);
Route::get('/check_mobile/{id}', [Admin\StudentController::class,'check_mobile']);
Route::get('/get_package_amount/{id}/{period}', [Admin\StudentController::class,'get_package_amount']);
Route::get('/get_promocodes_by_course_id/{id}', [Admin\StudentController::class,'get_promocodes_by_course_id']);
Route::get('/get_referral_code_amount/{id}', [Admin\StudentController::class,'get_referral_code_amount']);
Route::get('/get_promocode_amount/{id}/{pid}', [Admin\StudentController::class,'get_promocode_amount']);
Route::get('/get_students_by_course_unique_id/{id}', [Admin\StudentController::class,'get_students_by_course_unique_id']);

Route::get('/add_package/{id}', [Admin\StudentController::class,'add_package']);
Route::post('/update_package', [Admin\StudentController::class,'update_package']);

Route::get('/import_students', [Admin\StudentController::class,'import_students']);
Route::post('/import_student_users', [Admin\StudentController::class,'import_student_users']);

//Student subscriptions

Route::resource('/subscriptions', Admin\SubscriptionController::class);
Route::get('/view_subscriptions', [Admin\SubscriptionController::class,'view_data']);
Route::get('/delete_subscription/{id}', [Admin\SubscriptionController::class,'destroy']);


//promocodes

Route::resource('/promocodes', Admin\PromocodeController::class);
Route::get('/view_promocodes', [Admin\PromocodeController::class,'view_data']);
Route::get('/edit_promocode/{id}', [Admin\PromocodeController::class,'edit']);
Route::post('/update_promocode', [Admin\PromocodeController::class,'update_promocode']);
Route::get('/delete_promocode/{id}', [Admin\PromocodeController::class,'destroy']);
Route::get('/activate_deactivate_promocode/{id}/{op}', [Admin\PromocodeController::class,'activate_deactivate']);
//staffs

Route::resource('/staffs', Admin\StaffController::class);
Route::get('/view_staffs', [Admin\StaffController::class,'view_data']);
Route::get('/edit_staff/{id}', [Admin\StaffController::class,'edit']);
Route::post('/update_staff', [Admin\StaffController::class,'update_staff']);
Route::get('/delete_staff/{id}', [Admin\StaffController::class,'destroy']);
Route::get('/activate_staff/{id}', [Admin\StaffController::class,'activate']);
Route::get('/deactivate_staff/{id}', [Admin\StaffController::class,'deactivate']);
Route::get('/check_referral_code/{id}', [Admin\StaffController::class,'check_referral_code']);

//users

Route::resource('/student_users', Admin\UserController::class);
Route::get('/view_student_users', [Admin\UserController::class,'view_data']);
Route::get('/edit_student_user/{id}', [Admin\UserController::class,'edit']);
Route::post('/update_student_user', [Admin\UserController::class,'update_student_user']);
Route::get('/delete_user/{id}', [Admin\UserController::class,'destroy']);
Route::get('/activate_user/{id}', [Admin\UserController::class,'activate']);
Route::get('/deactivate_user/{id}', [Admin\UserController::class,'deactivate']);

Route::get('/admin_users', [Admin\UserController::class,'admin_users']);
Route::post('/add_admin_user', [Admin\UserController::class,'add_admin_user']);
Route::get('/edit_admin_user/{id}', [Admin\UserController::class,'edit_admin_user']);
Route::post('/update_admin_user', [Admin\UserController::class,'update_admin_user']);
Route::get('/view_admin_users', [Admin\UserController::class,'view_admin_data']);
Route::get('/delete_admin_user/{id}', [Admin\UserController::class,'remove_user']);
Route::get('/activate_admin/{id}', [Admin\UserController::class,'activate_admin']);
Route::get('/deactivate_admin/{id}', [Admin\UserController::class,'deactivate_admin']);

//student Devices details
Route::resource('/student_devices', Admin\StudentDeviceController::class);
Route::get('/view_student_devices', [Admin\StudentDeviceController::class,'view_data']);
Route::get('/delete_student_device/{id}', [Admin\StudentDeviceController::class,'destroy']);


//student attended test details
Route::resource('/attended_tests', Admin\AttendedTestController::class);
Route::get('/view_student_names/{id}', [Admin\AttendedTestController::class,'view_student_names']);
Route::get('/view_test_details', [Admin\AttendedTestController::class,'view_test_details']);
//Route::get('/delete_student_device/{id}', [Admin\StudentDeviceController::class,'destroy']);

//latest news
Route::resource('/latest_news', Admin\LatestNewsController::class);
Route::get('/view_latest_news', [Admin\LatestNewsController::class,'view_data']);
Route::get('/edit_latest_news/{id}', [Admin\LatestNewsController::class,'edit']);
Route::post('/update_latest_news', [Admin\LatestNewsController::class,'update_latest_news']);
Route::get('/activate_deactivate_news/{op}/{id}', [Admin\LatestNewsController::class,'activate_deactivate_news']);
Route::get('/delete_latest_news/{id}', [Admin\LatestNewsController::class,'destroy']);
Route::get('/get_more_latest_news/{id}', [Admin\LatestNewsController::class,'get_more_latest_news']);


//latest news
Route::resource('/subject_live_class', Admin\SubjectLiveClassController::class);
Route::get('/view_subject_live_class', [Admin\SubjectLiveClassController::class,'view_data']);
Route::get('/edit_subject_live_class/{id}', [Admin\SubjectLiveClassController::class,'edit']);
Route::post('/update_subject_live_class', [Admin\SubjectLiveClassController::class,'update_subject_live_class']);
Route::get('/act_deact_subject_live_class/{op}/{id}', [Admin\SubjectLiveClassController::class,'activate_deactivate_live_class']);
Route::get('/delete_subject_live_class/{id}', [Admin\SubjectLiveClassController::class,'destroy']);


//dash live mock test
Route::resource('/live_mock_tests', Admin\DashLiveMockTestController::class);
Route::get('/get_live_mock_test_qpapers/{id}', [Admin\DashLiveMockTestController::class,'get_live_mock_test_qpapers']);
Route::post('/save_live_mock_test', [Admin\DashLiveMockTestController::class,'store']);
Route::get('/view_dash_live_mock_tests', [Admin\DashLiveMockTestController::class,'view_data']);
Route::get('/delete_dash_live_test/{id}', [Admin\DashLiveMockTestController::class,'destroy']);


//notifications
Route::resource('/notifications', Admin\SendNotificationController::class);
Route::get('/view_notifications', [Admin\SendNotificationController::class,'view_data']);
Route::get('/delete_notification/{id}', [Admin\SendNotificationController::class,'destroy']);
Route::get('/act_deact_notification/{id}/{op}', [Admin\SendNotificationController::class,'act_deact_notification']);


//Reports
Route::resource('/exam_reports', Admin\ReportController::class);
Route::get('/view_mcq_rank_wise_list', [Admin\ReportController::class,'view_data']);
//Route::get('/rank_list/{id}', [Admin\ReportController::class,'rank_list']);
Route::get('/export_mcq_rank_list/{qpid}', [Admin\ReportController::class,'export_mcq_rank_list']);

Route::get('/mcq_student_wise_report', [Admin\ReportController::class,'mcq_student_wise_report']);
Route::get('/view_student_data', [Admin\ReportController::class,'view_student_data']);
Route::get('/export_mcq_student_list/{stid}', [Admin\ReportController::class,'export_mcq_student_list']);

Route::get('/student_list_report', [Admin\ReportController::class,'student_list_report']);
Route::get('/view_student_list', [Admin\ReportController::class,'view_student_list']);
Route::get('/export_student_list/{stid}', [Admin\ReportController::class,'export_student_list']);

Route::get('/subscription_list_report', [Admin\ReportController::class,'subscription_list_report']);
Route::get('/view_subscription_list', [Admin\ReportController::class,'view_subscription_list']);
Route::get('/export_subscription_list/{stid}', [Admin\ReportController::class,'export_subscription_list']);

Route::get('/discount_list_report', [Admin\ReportController::class,'discount_list_report']);
Route::get('/view_discount_list', [Admin\ReportController::class,'view_discount_list']);
Route::get('/export_discount_list/{op}/{prc}/{rfc}', [Admin\ReportController::class,'export_discount_list']);

//chat details
Route::resource('/chat', Admin\ChatController::class);
Route::get('/get_chat_messages/{id}', [Admin\ChatController::class,'get_chat_messages']);
Route::get('/view_chat_students', [Admin\ChatController::class,'view_data']);
Route::post('/add_admin_chat_message', [Admin\ChatController::class,'store']);
Route::get('/remove_chat_message/{id}', [Admin\ChatController::class,'remove_chat_message']);

Route::post('/add_image', [Admin\ChatController::class,'add_image']);

Route::resource('/social_media', Admin\SocialMediaController::class);
Route::post('/update_social_media', [Admin\SocialMediaController::class,'update_social_media']);

//e-book titles
Route::resource('/ebooks', Admin\EbookController::class);
Route::post('/save_ebook', [Admin\EbookController::class,'store']);
Route::get('/view_ebooks', [Admin\EbookController::class,'view_data']);
Route::get('/edit_ebook/{id}', [Admin\EbookController::class,'edit']);
Route::post('/update_ebook', [Admin\EbookController::class,'update_ebook']);
Route::get('/delete_ebook/{id}', [Admin\EbookController::class,'destroy']);

//e-book html files

Route::get('/ebook_files', [Admin\EbookHtmlFileController::class,'index']);
Route::post('/save_html_file', [Admin\EbookHtmlFileController::class,'store']);
Route::get('/view_html_files', [Admin\EbookHtmlFileController::class,'view_data']);
Route::get('/edit_html_file/{id}', [Admin\EbookHtmlFileController::class,'edit']);
Route::post('/update_html_file', [Admin\EbookHtmlFileController::class,'update_html_file']);
Route::get('/delete_html_file/{id}', [Admin\EbookHtmlFileController::class,'destroy']);

Route::get('/email_bill', [Admin\BillEmailController::class,'index']);
Route::get('/bill_email', [Admin\BillEmailController::class,'send_bill_to_mail']);

Route::get('/generate-pdf', [Admin\PDFController::class,'generate_pdf']);
//Route::get('/delete_notification/{id}', [Admin\NotificationController::class,'destroy']);
//Route::get('/act_deact_notification/{id}/{op}', [Admin\NotificationController::class,'act_deact_notification']);

/*Route::get('/view_latest_news', [Admin\DashLiveMockTestController::class,'view_data']);
Route::get('/edit_latest_news/{id}', [Admin\DashLiveMockTestController::class,'edit']);
Route::post('/update_latest_news', [DashLiveMockTestController::class,'update_latest_news']);
Route::get('/activate_deactivate_news/{op}/{id}', [Admin\LatestNewsController::class,'activate_deactivate_news']);
Route::get('/delete_latest_news/{id}', [Admin\LatestNewsController::class,'destroy']);*/




