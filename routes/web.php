<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ManageUser;
use App\Http\Controllers\Dean\DeanController;
use Illuminate\Support\Facades\Auth;


//Admin Controls
use App\Http\Controllers\Admin\AdminCollegeController;
use App\Http\Controllers\Admin\AdminCurrController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Auth\EditProfileController;
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderAuditController;
//Chair Controls
use App\Http\Controllers\Chairperson\ChairController;
use App\Http\Controllers\Chairperson\ChairPOController;
use App\Http\Controllers\Chairperson\ChairPOEController;
use App\Http\Controllers\Chairperson\ChairCurrController;
use App\Http\Controllers\Chairperson\ChairCourseController;
use App\Http\Controllers\Chairperson\ChairDeadlineController;

//Bayanihan Leader Controls
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderHomeController;
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderSyllabusController;
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderCoController;
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderCOTController;
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderCRQController;
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderPDFController;
use App\Http\Controllers\BayanihanLeader\BayanihanLeaderTOSController;
//Bayanihan Teacher Controls
use App\Http\Controllers\BayanihanTeacher\BayanihanTeacherSyllabusController;
use App\Http\Controllers\BayanihanTeacher\BayanihanTeacherTOSController;
use App\Http\Controllers\Chairperson\ChairReportsController;
use App\Http\Controllers\Chairperson\ChairSyllabusController;
use App\Http\Controllers\Chairperson\ChairTOSController;
use App\Http\Controllers\Dean\DeanDeadlineController;
use App\Http\Controllers\Dean\DeanReportsController;
use App\Http\Controllers\Dean\DeanSyllabusController;
use App\Http\Controllers\PDF\DocController;
use App\Http\Controllers\PDF\PDFController;
use App\Livewire\BLCommentModal;
use App\Models\Course;
use App\Models\Curriculum;
use Livewire\Livewire;

Route::get('/', function () {
    return view('auth/login');
});
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/custom/livewire/update', $handle);
});

//Email Verification
Auth::routes(['verify' => true]);

Route::prefix('')->middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Syllabus and TOS Download 
    Route::get('/generateSyllabusPDF/{syll_id}', [PDFController::class, 'generateSyllabusPDF'])->name('generateSyllabusPDF');
    Route::get('/generateTOSPDF/{tos_id}', [PDFController::class, 'generateTOSPDF'])->name('generateTOSPDF');
});

//User Imports
Route::post('/fileUserImport', [ManageUser::class, 'fileUserImport'])->name('fileUserImport');
Route::get('/export-users', [ManageUser::class, 'fileUserExport'])->name('fileUserExport');


//Bayanihan Teacher
Route::group(['prefix' => 'bayanihanteacher', 'middleware' => ['auth', 'isBT']], function () {
    Route::get('/home', [BayanihanTeacherSyllabusController::class, 'index'])->name('bayanihanteacher.home');
    Route::get('/syllabus', [BayanihanTeacherSyllabusController::class, 'syllabus'])->name('bayanihanteacher.syllabus');
    Route::get('/syllabus/commentSyllabus/{syll_id}', [BayanihanTeacherSyllabusController::class, 'commentSyllabus'])->name('bayanihanteacher.commentSyllabus');
    Route::get('/syllabus/viewReviewForm/{syll_id}', [BayanihanTeacherSyllabusController::class, 'viewReviewForm'])->name('bayanihanteacher.viewReviewForm');

    Route::get('/tos', [BayanihanTeacherTOSController::class, 'index'])->name('bayanihanteacher.tos');
    Route::get('/tos/commentTos/{tos_id}', [BayanihanTeacherTOSController::class, 'commentTos'])->name('bayanihanteacher.commentTos');

    // Audit Trail 
    Route::get('/syllabus/auditTrail/{syll_id}', [BayanihanLeaderAuditController::class, 'viewAudit'])->name('bayanihanteacher.viewAudit');
    Route::get('/tos/auditTrail/{tos_id}', [BayanihanLeaderAuditController::class, 'viewTosAudit'])->name('bayanihanteacher.viewTosAudit');
});


//Bayanihan Leader
Route::group(['prefix' => 'bayanihanleader', 'middleware' => ['auth', 'isBL']], function () {

    // Route::get('pdfSyllabus/{syll_id}', [BayanihanLeaderPDFController::class, 'pdfSyllabus'])->name('bayanihanleader.pdfSyllabus');
    Route::get('pdfTOS/{tos_id}', [PDFController::class, 'pdf2'])->name('bayanihanleader.pdfSyllabus');
    Route::get('/syllabus/commentSyllabus/{syll_id}', [BayanihanLeaderSyllabusController::class, 'commentSyllabus'])->name('bayanihanleader.commentSyllabus');

    Route::get('/home', [BayanihanLeaderHomeController::class, 'index'])->name('bayanihanleader.home');

    Route::get('/syllabus', [BayanihanLeaderSyllabusController::class, 'index'])->name('bayanihanleader.syllabus');
    Route::get('/syllabus/createSyllabus', [BayanihanLeaderSyllabusController::class, 'createSyllabus'])->name('bayanihanleader.createSyllabus');
    Route::post('/syllabus/storeSyllabus', [BayanihanLeaderSyllabusController::class, 'storeSyllabus'])->name('bayanihanleader.storeSyllabus');
    Route::get('/syllabus/viewSyllabus/{syll_id}', [BayanihanLeaderSyllabusController::class, 'viewSyllabus'])->name('bayanihanleader.viewSyllabus');
    Route::get('/syllabus/editSyllabus/{syll_id}', [BayanihanLeaderSyllabusController::class, 'editSyllabus'])->name('bayanihanleader.editSyllabus');
    Route::put('/syllabus/updateSyllabus/{syll_id}', [BayanihanLeaderSyllabusController::class, 'updateSyllabus'])->name('bayanihanleader.updateSyllabus');
    Route::delete('/syllabus/destroySyllabus/{syll_id}', [BayanihanLeaderSyllabusController::class, 'destroySyllabus'])->name('bayanihanleader.destroySyllabus');

    Route::get('/syllabus/pdf/{syll_id}', [PDFController::class, 'pdf'])->name('pdf');
    Route::get('/reviewform/{syll_id}', [DocController::class, 'downloadReviewForm'])->name('downloadReviewForm');

    Route::get('/syllabus/createCo/{syll_id}', [BayanihanLeaderCoController::class, 'createCo'])->name('bayanihanleader.createCo');
    Route::post('/syllabus/storeCo/{syll_id}', [BayanihanLeaderCoController::class, 'storeCo'])->name('bayanihanleader.storeCo');
    Route::get('/syllabus/editCo/{syll_id}', [BayanihanLeaderCoController::class, 'editCo'])->name('bayanihanleader.editCo');
    Route::put('/syllabus/updateCo/{syll_id}', [BayanihanLeaderCoController::class, 'updateCo'])->name('bayanihanleader.updateCo');
    Route::delete('/syllabus/destroyCo/{co_id}/{syll_id}', [BayanihanLeaderCoController::class, 'destroyCo'])->name('bayanihanleader.destroyCo');

    Route::get('/syllabus/createCoPo/{syll_id}', [BayanihanLeaderCoController::class, 'createCoPo'])->name('bayanihanleader.createCoPo');
    Route::post('/syllabus/storeCoPo/{syll_id}', [BayanihanLeaderCoController::class, 'storeCoPo'])->name('bayanihanleader.storeCoPo');
    Route::get('/syllabus/editCoPo/{syll_id}', [BayanihanLeaderCoController::class, 'editCoPo'])->name('bayanihanleader.editCoPo');
    Route::put('/syllabus/updateCoPo/{syll_id}', [BayanihanLeaderCoController::class, 'updateCoPo'])->name('bayanihanleader.updateCoPo');

    Route::get('/syllabus/createCot/{syll_id}', [BayanihanLeaderCOTController::class, 'createCot'])->name('bayanihanleader.createCot');
    Route::get('/syllabus/createCotF/{syll_id}', [BayanihanLeaderCOTController::class, 'createCotF'])->name('bayanihanleader.createCotF');
    Route::get('/syllabus/createCrq/{syll_id}', [BayanihanLeaderCRQController::class, 'createCrq'])->name('bayanihanleader.createCrq');

    Route::post('/syllabus/storeCot/{syll_id}', [BayanihanLeaderCOTController::class, 'storeCot'])->name('bayanihanleader.storeCot');
    Route::post('/syllabus/storeCotF/{syll_id}', [BayanihanLeaderCOTController::class, 'storeCotF'])->name('bayanihanleader.storeCotF');

    Route::get('/syllabus/editCot/{syll_co_out_id}/{syll_id}', [BayanihanLeaderCOTController::class, 'editCot'])->name('bayanihanleader.editCot');
    Route::get('/syllabus/editCotF/{syll_co_out_id}/{syll_id}', [BayanihanLeaderCOTController::class, 'editCotF'])->name('bayanihanleader.editCotF');

    Route::put('/syllabus/updateCot/{syll_co_out_id}/{syll_id}', [BayanihanLeaderCOTController::class, 'updateCot'])->name('bayanihanleader.updateCot');
    Route::put('/syllabus/updateCotF/{syll_co_out_id}/{syll_id}', [BayanihanLeaderCOTController::class, 'updateCotF'])->name('bayanihanleader.updateCotF');
    Route::put('/syllabus/updateCrq/{syll_id}', [BayanihanLeaderCRQController::class, 'updateCrq'])->name('bayanihanleader.updateCrq');

    Route::delete('/syllabus/destroyCot/{syll_co_out_id}/{syll_id}', [BayanihanLeaderCOTController::class, 'destroyCot'])->name('bayanihanleader.destroyCot');
    Route::delete('/syllabus/destroyCotF/{syll_co_out_id}/{syll_id}', [BayanihanLeaderCOTController::class, 'destroyCotF'])->name('bayanihanleader.destroyCotF');


    Route::put('/syllabus/submitSyllabus/{syll_id}', [BayanihanLeaderSyllabusController::class, 'submitSyllabus'])->name('bayanihanleader.submitSyllabus');
    Route::get('/syllabus/viewReviewForm/{syll_id}', [BayanihanLeaderSyllabusController::class, 'viewReviewForm'])->name('bayanihanleader.viewReviewForm');

    Route::get('/syllabus/replicate/{syll_id}', [BayanihanLeaderSyllabusController::class, 'replicateSyllabus'])->name('bayanihanleader.replicateSyllabus');

    // Row Edit 
    Route::get('/syllabus/editCotRowM/{syll_id}', [BayanihanLeaderCOTController::class, 'editCotRowM'])->name('bayanihanleader.editCotRowM');
    Route::post('/syllabus/updateCotRowM/{syll_id}', [BayanihanLeaderCOTController::class, 'updateCotRowM'])->name('bayanihanleader.updateCotRowM');
    Route::get('/syllabus/editCotRowF/{syll_id}', [BayanihanLeaderCOTController::class, 'editCotRowF'])->name('bayanihanleader.editCotRowF');
    Route::post('/syllabus/updateCotRowF/{syll_id}', [BayanihanLeaderCOTController::class, 'updateCotRowF'])->name('bayanihanleader.updateCotRowF');

    // TOS 
    Route::get('/tos', [BayanihanLeaderTOSController::class, 'index'])->name('bayanihanleader.tos');
    Route::get('/createTos/{tos_id}', [BayanihanLeaderTOSController::class, 'createTos'])->name('bayanihanleader.createTos');
    Route::post('/storeTos/{tos_id}', [BayanihanLeaderTOSController::class, 'storeTos'])->name('bayanihanleader.storeTos');
    Route::get('/viewTos/{tos_id}', [BayanihanLeaderTOSController::class, 'viewTos'])->name('bayanihanleader.viewTos');
    
    Route::get('/editTosRow/{tos_id}', [BayanihanLeaderTOSController::class, 'editTosRow'])->name('bayanihanleader.editTosRow');
    Route::post('/updateTosRow/{tos_id}', [BayanihanLeaderTOSController::class, 'updateTosRow'])->name('bayanihanleader.updateTosRow');

    Route::get('/commentTos/{tos_id}', [BayanihanLeaderTOSController::class, 'commentTos'])->name('bayanihanleader.commentTos');
    Route::get('/editTos/{syll_id}/{tos_id}', [BayanihanLeaderTOSController::class, 'editTos'])->name('bayanihanleader.editTos');
    Route::put('/updateTos/{syll_id}/{tos_id}', [BayanihanLeaderTOSController::class, 'updateTos'])->name('bayanihanleader.updateTos');
    Route::delete('/destroyTos/{tos_id}', [BayanihanLeaderTOSController::class, 'destroyTos'])->name('bayanihanleader.destroyTos');
    Route::put('/submitTos/{tos_id}', [BayanihanLeaderTOSController::class, 'submitTos'])->name('bayanihanleader.submitTos');

    // Replicate TOS 
    Route::get('/replicateTos/{tos_id}', [BayanihanLeaderTOSController::class, 'replicateTos'])->name('bayanihanleader.replicateTos');

    // Audit Trail 
    Route::get('/syllabus/auditTrail/{syll_id}', [BayanihanLeaderAuditController::class, 'viewAudit'])->name('bayanihanleader.viewAudit');
    Route::get('/tos/auditTrail/{tos_id}', [BayanihanLeaderAuditController::class, 'viewTosAudit'])->name('bayanihanleader.viewTosAudit');
});

//Chairperson:
Route::group(['prefix' => 'chairperson', 'middleware' => ['auth', 'isChair']], function () {
    // Bayanihan Team 
    Route::get('/home', [ChairController::class, 'index'])->name('chairperson.home');

    Route::get('/bayanihan', [ChairController::class, 'bayanihan'])->name('chairperson.bayanihan');
    Route::get('/createBTeam', [ChairController::class, 'createBTeam'])->name('chairperson.createBTeam');
    Route::post('/storeBTeam', [ChairController::class, 'storeBTeam'])->name('chairperson.storeBTeam');
    Route::get('/editBTeam/{bg_id}', [ChairController::class, 'editBTeam'])->name('chairperson.editBTeam');
    Route::put('/{bg_id}', [ChairController::class, 'updateBTeam'])->name('chairperson.updateBTeam');
    Route::delete('/destroyBTeam/{bg_id}', [ChairController::class, 'destroyBTeam'])->name('chairperson.destroyBTeam');

    Route::get('chairperson/mail', [ChairController::class, 'mail'])->name('chairperson.mail');

    // Program Outcome and Educ Obj 
    Route::get('/programOutcome', [ChairPOController::class, 'index'])->name('chairperson.programOutcome');
    Route::get('/programOutcome/createPo', [ChairPOController::class, 'createPo'])->name('chairperson.createPo');
    Route::post('/programOutcome/storePo', [ChairPOController::class, 'storePo'])->name('chairperson.storePo');
    Route::get('/programOutcome/editPo/{department_id}', [ChairPOController::class, 'editPo'])->name('chairperson.editPo');
    Route::put('/programOutcome/updatePo/{po_id}', [ChairPOController::class, 'updatePo'])->name('chairperson.updatePo');
    Route::delete('/programOutcome/destroyPo/{po_id}', [ChairPOController::class, 'destroyPo'])->name('chairperson.destroyPo');

    Route::get('/poe', [ChairPOEController::class, 'index'])->name('chairperson.poe');
    Route::get('/createPoe', [ChairPOEController::class, 'createPoe'])->name('chairperson.createPoe');
    Route::post('/poe/storePoe', [ChairPOEController::class, 'storePoe'])->name('chairperson.storePoe');
    Route::get('/poe/editPoe/{department_id}', [ChairPOEController::class, 'editPoe'])->name('chairperson.editPoe');
    Route::put('/poe/updatePoe/{poe_id}', [ChairPOEController::class, 'updatePoe'])->name('chairperson.updatePoe');
    Route::delete('/poe/destroyPoe/{poe_id}', [ChairPOEController::class, 'destroyPoe'])->name('chairperson.destroyPoe');

    // Curricula
    Route::get('/curr', [ChairCurrController::class, 'index'])->name('chairperson.curr');
    Route::get('/curr/createCurr', [ChairCurrController::class, 'createCurr'])->name('chairperson.createCurr');
    Route::post('/curr/storeCurr', [ChairCurrController::class, 'storeCurr'])->name('chairperson.storeCurr');
    Route::get('/curr/editCurr/{curr_id}', [ChairCurrController::class, 'editCurr'])->name('chairperson.editCurr');
    Route::put('/curr/updateCurr/{curr_id}', [ChairCurrController::class, 'updateCurr'])->name('chairperson.updateCurr');
    Route::delete('/curr/destroyCurr/{curr_id}', [ChairCurrController::class, 'destroyCurr'])->name('chairperson.destroyCurr');

    // Course 
    Route::get('/course', [ChairCourseController::class, 'index'])->name('chairperson.course');
    Route::get('/course/createCourse', [ChairCourseController::class, 'createCourse'])->name('chairperson.createCourse');
    Route::post('/course/storeCourse', [ChairCourseController::class, 'storeCourse'])->name('chairperson.storeCourse');
    Route::get('/course/editCourse/{course_id}', [ChairCourseController::class, 'editCourse'])->name('chairperson.editCourse');
    Route::put('/course/updateCourse/{course_id}', [ChairCourseController::class, 'updateCourse'])->name('chairperson.updateCourse');
    Route::delete('/course/destroyCourse/{course_id}', [ChairCourseController::class, 'destroyCourse'])->name('chairperson.destroyCourse');
    Route::get('/course/viewCourse/{course_id}', [ChairCourseController::class, 'viewCourse'])->name('chairperson.viewCourse');

    // Syllabus 
    Route::get('/syallbus', [ChairSyllabusController::class, 'index'])->name('chairperson.syllabus');
    Route::get('/syllabus/viewSyllabus/{syll_id}', [ChairSyllabusController::class, 'viewSyllabus'])->name('chairperson.viewSyllabus');
    Route::put('/syllabus/approveSyllabus/{syll_id}', [ChairSyllabusController::class, 'approveSyllabus'])->name('chairperson.approveSyllabus');
    Route::PUT('/syllabus/rejectSyllabus/{syll_id}', [ChairSyllabusController::class, 'rejectSyllabus'])->name('chairperson.rejectSyllabus');
    Route::post('/syllabus/return/{syll_id}', [ChairSyllabusController::class, 'returnSyllabus'])->name('chairperson.returnSyllabus');
    Route::get('/syallbus/reviewForm/{syll_id}', [ChairSyllabusController::class, 'reviewForm'])->name('chairperson.reviewForm');
    Route::get('/syallbus/commentSyllabus/{syll_id}', [ChairSyllabusController::class, 'commentSyllabus'])->name('chairperson.commentSyllabus');
    Route::get('/syallbus/viewReviewForm/{syll_id}', [ChairSyllabusController::class, 'viewReviewForm'])->name('chairperson.viewReviewForm');

    // TOS
    Route::get('/tos', [ChairTOSController::class, 'index'])->name('chairperson.tos');
    Route::get('/tos/viewTos/{tos_id}', [ChairTOSController::class, 'viewTos'])->name('chairperson.viewTos');
    Route::put('/tos/approveTos/{tos_id}', [ChairTOSController::class, 'approveTos'])->name('chairperson.approveTos');
    Route::put('/tos/returnTos/{tos_id}', [ChairTOSController::class, 'returnTos'])->name('chairperson.returnTos');

    Route::get('/tos/commentTos/{tos_id}', [ChairTOSController::class, 'commentTos'])->name('chairperson.commentTos');

    Route::get('/reports', [ChairReportsController::class, 'index'])->name('chairperson.reports');

});

Route::group(['prefix' => 'dean', 'middleware' => ['auth', 'isDean']], function () {
    Route::get('/', [DeanController::class, 'index'])->name('dean.home');
    Route::get('/chairs', [DeanController::class, 'chairperson'])->name('dean.chairs');
    Route::get('/departments', [DeanController::class, 'departments'])->name('dean.departments');

    Route::get('/createDepartment', [DeanController::class, 'createDepartment'])->name('dean.createDepartment');
    Route::post('/storeDepartment', [DeanController::class, 'storeDepartment'])->name('dean.storeDepartment');
    Route::get('/editDepartment/{department_id}', [DeanController::class, 'editDepartment'])->name('dean.editDepartment');
    Route::put('/updateDepartment/{department_id}', [DeanController::class, 'updateDepartment'])->name('dean.updateDepartment');
    Route::delete('/departments/{department_id}', [DeanController::class, 'destroyDepartment'])->name('dean.destroyDepartment');

    Route::get('/createChair', [DeanController::class, 'createChair'])->name('dean.createChair');
    Route::post('/storeChair', [DeanController::class, 'storeChair'])->name('dean.storeChair');
    Route::get('/editChair/{chairman_id}', [DeanController::class, 'editChair'])->name('dean.editChair');
    Route::put('/updateChair/{chairman_id}', [DeanController::class, 'updateChair'])->name('dean.updateChair');
    Route::delete('/destroyChair/{chairman_id}', [DeanController::class, 'destroyChair'])->name('dean.destroyChair');

    Route::get('syllabus/syllList', [DeanSyllabusController::class, 'index'])->name('dean.syllList');
    Route::get('syllabus/syllView/{syll_id}', [DeanSyllabusController::class, 'viewSyllabus'])->name('dean.viewSyllabus');
    Route::PUT('/syllabus/returnSyllabus/{syll_id}', [DeanSyllabusController::class, 'returnSyllabus'])->name('dean.returnSyllabus');
    Route::put('/syllabus/approveSyllabus/{syll_id}', [DeanSyllabusController::class, 'approveSyllabus'])->name('dean.approveSyllabus');

    Route::get('/deadline', [DeanDeadlineController::class, 'deadline'])->name('dean.deadline');
    Route::get('/createdeadline', [DeanDeadlineController::class, 'createDeadline'])->name('dean.createDeadline');
    Route::post('/storeDeadline', [DeanDeadlineController::class, 'storeDeadline'])->name('dean.storeDeadline');
    Route::get('/editDeadline/{dl_id}', [DeanDeadlineController::class, 'editDeadline'])->name('dean.editDeadline');
    Route::put('updateDeadline/{dl_id}', [DeanDeadlineController::class, 'updateDeadline'])->name('dean.updateDeadline');
    Route::delete('/destroyDeadline/{bg_id}', [DeanDeadlineController::class, 'destroyDeadline'])->name('dean.destroyDeadline');

    Route::get('/editDeadline', [DeanReportsController::class, 'index'])->name('dean.reports');

});

// //Route for admin
// Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function () {
//     Route::get('/home', [ManageUser::class, 'index'])->name('admin.home');
//     Route::resource('admin', ManageUser::class);
//     Route::get('/createRole/{user_id}', [ManageUser::class, 'createRole'])->name('admin.createRole');
//     Route::post('/storeRole', [ManageUser::class, 'storeRole'])->name('admin.storeRole');
//     Route::get('/editRoles/{userid}', [ManageUser::class, 'editRoles'])->name('admin.editRoles');
//     Route::put('/updateRoles/{role_id}', [ManageUser::class, 'updateRoles'])->name('admin.updateRoles');
//     Route::delete('/destroyRoles/{role_id}', [ManageUser::class, 'destroyRoles'])->name('admin.destroyRoles');
//     Route::post('/{userid}', [ManageUser::class, 'update']);

//     // College 


//     // Curriculum 
//     Route::get('/curr', [AdminCurrController::class, 'index'])->name('admin.curr');
//     Route::get('/createCurr', [AdminCurrController::class, 'createCurr'])->name('admin.createCurr');
//     Route::post('/storeCurr', [AdminCurrController::class, 'storeCurr'])->name('admin.storeCurr');
//     Route::get('/editCurr/{curr_id}', [AdminCurrController::class, 'editCurr'])->name('admin.editCurr');
//     Route::put('/updateCurr/{curr_id}', [AdminCurrController::class, 'updateCurr'])->name('admin.updateCurr');
//     Route::delete('/destroyCurr/{curr_id}', [AdminCurrController::class, 'destroyCurr'])->name('admin.destroyCurr');

//     // Course 
//     Route::get('/course', [AdminCourseController::class, 'index'])->name('admin.course');
//     Route::get('/createCourse', [AdminCourseController::class, 'createCourse'])->name('admin.createCourse');
//     Route::post('/storeCourse', [AdminCourseController::class, 'storeCourse'])->name('admin.storeCourse');
//     Route::get('/editCourse/{course_id}', [AdminCourseController::class, 'editCourse'])->name('admin.editCourse');
//     Route::put('updateCourse/{course_id}', [AdminCourseController::class, 'updateCourse'])->name('admin.updateCourse');
//     Route::delete('/destroyCourse/{course_id}', [AdminCourseController::class, 'destroyCourse'])->name('admin.destroyCourse');

//     // Department 
//     Route::get('/department', [AdminDepartmentController::class, 'index'])->name('admin.department');
//     Route::get('/createDepartment', [AdminDepartmentController::class, 'createDepartment'])->name('admin.createDepartment');
//     Route::post('/storeDepartment', [AdminDepartmentController::class, 'storeDepartment'])->name('admin.storeDepartment');
//     Route::get('/editDepartment/{department_id}', [AdminDepartmentController::class, 'editDepartment'])->name('admin.editDepartment');
//     Route::put('updateDepartment/{department_id}', [AdminDepartmentController::class, 'updateDepartment'])->name('admin.updateDepartment');
//     Route::delete('/destroyDepartment/{department_id}', [AdminDepartmentController::class, 'destroyDepartment'])->name('admin.destroyDepartment');

//     // Chair 
//     Route::get('/createChair', [AdminDepartmentController::class, 'createChair'])->name('admin.createChair');
//     Route::post('/storeChair', [AdminDepartmentController::class, 'storeChair'])->name('admin.storeChair');
//     Route::get('/editChair/{chairman_id}', [AdminDepartmentController::class, 'editChair'])->name('admin.editChair');
//     Route::put('/updateChair/{chairman_id}', [AdminDepartmentController::class, 'updateChair'])->name('admin.updateChair');
//     Route::delete('/destroyChair/{chairman_id}', [AdminDepartmentController::class, 'destroyChair'])->name('admin.destroyChair');
// });

Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('editProfile', [EditProfileController::class, 'editProfile'])->name('profile.edit');
    Route::put('updateProfile', [EditProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('editPassword', [EditProfileController::class, 'editPassword'])->name('password.edit');
    Route::post('updatePassword', [EditProfileController::class, 'updatePassword'])->name('password.update');
});



//Admin: Department Controller
Route::prefix('/')->middleware('isAdmin', 'auth')->group(function () {
    Route::get('admin/department', [AdminDepartmentController::class, 'index'])->name('admin.department');
    Route::get('/createDepartment', [AdminDepartmentController::class, 'createDepartment'])->name('admin.createDepartment');
    Route::post('/storeDepartment', [AdminDepartmentController::class, 'storeDepartment'])->name('admin.storeDepartment');
    Route::get('/editDepartment/{department_id}', [AdminDepartmentController::class, 'editDepartment'])->name('admin.editDepartment');
    Route::put('updateDepartment/{department_id}', [AdminDepartmentController::class, 'updateDepartment'])->name('admin.updateDepartment');
    Route::delete('/destroyDepartment/{department_id}', [AdminDepartmentController::class, 'destroyDepartment'])->name('admin.destroyDepartment');

    Route::get('/createChair', [AdminDepartmentController::class, 'createChair'])->name('admin.createChair');
    Route::post('/storeChair', [AdminDepartmentController::class, 'storeChair'])->name('admin.storeChair');
    Route::get('/editChair/{chairman_id}', [AdminDepartmentController::class, 'editChair'])->name('admin.editChair');
    Route::put('/updateChair/{chairman_id}', [AdminDepartmentController::class, 'updateChair'])->name('admin.updateChair');
    Route::delete('/destroyChair/{chairman_id}', [AdminDepartmentController::class, 'destroyChair'])->name('admin.destroyChair');
});

//Admin: Course Controller
Route::prefix('/')->middleware('isAdmin', 'auth')->group(function () {
    Route::get('admin/course', [AdminCourseController::class, 'index'])->name('admin.course');
    Route::get('/createCourse', [AdminCourseController::class, 'createCourse'])->name('admin.createCourse');
    Route::post('/storeCourse', [AdminCourseController::class, 'storeCourse'])->name('admin.storeCourse');
    Route::get('/editCourse/{course_id}', [AdminCourseController::class, 'editCourse'])->name('admin.editCourse');
    Route::put('updateCourse/{course_id}', [AdminCourseController::class, 'updateCourse'])->name('admin.updateCourse');
    Route::delete('/destroyCourse/{course_id}', [AdminCourseController::class, 'destroyCourse'])->name('admin.destroyCourse');
});

//Admin: Curricula Controller
Route::prefix('/')->middleware('isAdmin', 'auth')->group(function () {
    Route::get('admin/curr', [AdminCurrController::class, 'index'])->name('admin.curr');
    Route::get('/createCurr', [AdminCurrController::class, 'createCurr'])->name('admin.createCurr');
    Route::post('/storeCurr', [AdminCurrController::class, 'storeCurr'])->name('admin.storeCurr');
    Route::get('/editCurr/{curr_id}', [AdminCurrController::class, 'editCurr'])->name('admin.editCurr');
    Route::put('updateCurr/{curr_id}', [AdminCurrController::class, 'updateCurr'])->name('admin.updateCurr');
    Route::delete('/destroyCurr/{curr_id}', [AdminCurrController::class, 'destroyCurr'])->name('admin.destroyCurr');
});

//Admin: College Controller
Route::prefix('/')->middleware('isAdmin', 'auth')->group(function () {
    Route::get('admin/college', [AdminCollegeController::class, 'index'])->name('admin.college')->middleware('isAdmin');
    Route::get('/createCollege', [AdminCollegeController::class, 'createCollege'])->name('admin.createCollege');
    Route::post('/storeCollege', [AdminCollegeController::class, 'storeCollege'])->name('admin.storeCollege');
    Route::get('/editCollege/{college_id}', [AdminCollegeController::class, 'editCollege'])->name('admin.editCollege');
    Route::put('updateCollege/{college_id}', [AdminCollegeController::class, 'updateCollege'])->name('admin.updateCollege');
    Route::delete('/destroyCollege/{college_id}', [AdminCollegeController::class, 'destroyCollege'])->name('admin.destroyCollege');
    Route::get('/createDean', [AdminCollegeController::class, 'createDean'])->name('createDean');
    Route::post('/storeDean', [AdminCollegeController::class, 'storeDean'])->name('storeDean');
    Route::get('/editDean/{dean_id}', [AdminCollegeController::class, 'editDean'])->name('editDean');
    Route::put('updateDean/{dean_id}', [AdminCollegeController::class, 'updateDean'])->name('updateDean');
    Route::delete('/destroyDean/{dean_id}', [AdminCollegeController::class, 'destroyDean'])->name('destroyDean');
});

//Route for admin
Route::prefix('/')->middleware('isAdmin', 'auth')->group(function () {
    Route::get('admin/home', [ManageUser::class, 'index'])->name('admin.home');
    Route::resource('admin', ManageUser::class);
    Route::get('admin/createRole/{user_id}', [ManageUser::class, 'createRole'])->name('admin.createRole');
    Route::post('admin/storeRole', [ManageUser::class, 'storeRole'])->name('admin.storeRole');
    Route::get('admin/editRoles/{userid}', [ManageUser::class, 'editRoles'])->name('admin.editRoles');
    Route::put('admin/updateRoles/{role_id}', [ManageUser::class, 'updateRoles'])->name('admin.updateRoles');
    Route::delete('admin/destroyRoles/{role_id}', [ManageUser::class, 'destroyRoles'])->name('admin.destroyRoles');
    Route::post('admin/{userid}', [ManageUser::class, 'update']);
});
