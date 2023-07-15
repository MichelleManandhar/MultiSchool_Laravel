<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MarkController;
use Illuminate\Session\Store;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user()->school()->first();
});

Route::post('register-custom','CustomAuth\AuthorizationController@register');
Route::post('login-custom','CustomAuth\AuthorizationController@login');
Route::get('login-refresh','CustomAuth\AuthorizationController@resetToken')->middleware('auth:api');

Route::get('classes' , 'ClassDetailController@index');
Route::get('class' , 'ClassDetailController@getAllClasses');

Route::post('{classid}/{sectionid}/subjects/store','SectionSubjectController@store');
Route::group(['middleware'=>['auth:api'],'prefix' => 'student'],function() {
    Route::get('/{section}', 'StudentController@getStudentsOfSection');
    Route::post('/store/{class}/{section}', 'StudentController@addStudentForSection');
    Route::post('/edit/{class}/{section}/{student}', 'StudentController@editStudentForSection');
});

Route::group(['middleware'=>['auth:api'],'prefix' => 'subject'],function() {
    Route::post('/store/{class}/{section}', 'SubjectController@addSubjectForSection');
    Route::post('/edit/{class}/{section}/{student}', 'SubjectController@editSubjecttForSection');
    Route::get('/remove/{subject}','SubjectController@remove');
});

Route::group(['middleware'=>['auth:api'],'prefix' => 'getAllSubject'],function() {
    Route::get('/', 'SubjectController@index');
});


Route::group(['middleware'=>['auth:api'],'prefix' => 'sponsor'],function() {
    Route::get('/','SponsorController@index');
    Route::post('/store','SponsorController@store');
    Route::post('/edit/{sponsor}','SponsorController@edit');
    Route::get('/destroy/{sponsor}','SponsorController@destroy');

});


Route::group(['middleware'=>['auth:api'],'prefix' => 'store-base-subject'],function() {
    Route::post('/','SubjectController@store');
});
Route::post('/edit-base-subject/{subject}','SubjectController@edit');

Route::group(['middleware'=>['auth:api'],'prefix' => 'exam'],function(){
    Route::get('/','ExamController@index')->name('index');
    Route::post('/store','ExamController@store')->name('store');
    Route::post('/edit/{exam}','ExamController@edit')->name('edit');
    Route::post('/destroy/{exam}','ExamController@destroy')->name('destroy');
    Route::get('/remove/{exam}','ExamController@remove')->name('remove');
});

Route::group(['middleware'=>['auth:api'],'prefix' => 'teachers'],function(){
    Route::get('/','TeacherController@index')->name('index');
});

Route::group(['middleware'=>['auth:api'],'prefix' => 'teacher'],function(){
    Route::get('/{section_id}' , 'SectionTeacherController@index');
    Route::post('/store','TeacherController@store')->name('store');
    Route::post('/edit/{teacher}','TeacherController@edit')->name('edit');
    Route::post('/destroy/{teacher}','TeacherController@destroy')->name('destroy');
    Route::get('/remove/{teacher}','TeacherController@remove');
});

Route::get('/section/{section}/teacher','TeacherController@getTeacherForSection');

Route::prefix('class/{class}/section')->group(function(){
    Route::get('/','SectionController@index');
    Route::post('/','SectionController@store');
    Route::put('/{section}','SectionController@update');
    Route::delete('/','SectionController@destroy');
});

Route::prefix('base-subject')->group(function(){
    Route::get('/getAllSubject','SubjectController@index');
    Route::post('/store-base-subject','SubjectController@store');
    Route::post('/edit-base-subject/{subject}','SubjectController@edit');
    Route::post('/delete','SubjectController@delete');
});


Route::prefix('/sectionsubject/{section}')->group(function(){
    Route::get('/','SectionSubjectController@index')->name('index');
    Route::post('/store','SectionSubjectController@store')->name('store');
    Route::post('/edit/{sectionSubject}','SectionSubjectController@edit')->name('edit');
    Route::post('/destroy/{sectionSubject}','SectionSubjectController@destroy')->name('destroy');
});

Route::get('get-student-section','AttendanceController@getStudentOfSection');

Route::prefix('attendance/{section}')->group(function(){
    Route::get('/','AttendanceController@index');
    Route::post('/store','AttendanceController@store');
    Route::post('/edit/{attendance}','AttendanceController@edit');
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

Route::prefix('marks')->group(function(){
    Route::post('/entry','MarkController@store');
    Route::post('/list','MarkController@index');
    Route::post('{section}/store/{exam}/fullmarks','MarkController@createOrUpdateFullMarks');
    Route::get('{section}/fullmarks/{exam}','MarkController@getSubjectPracticalAndTheoryMarks');
});
Route::group(['middleware'=>['auth:api'],'prefix' => 'school'],function(){
    Route::post('/store','SchoolInfoController@store');
    Route::get('/data/','SchoolInfoController@getSchoolDetails');
});

Route::group(['middleware'=>['auth:api'],'prefix' => 'idTemplate'],function(){
    Route::post('/submit','IdTemplateController@store');
    Route::get('/','IdTemplateController@index');
});
Route::group(['middleware'=>['auth:api'],'prefix' => 'class'],function(){
    Route::get('/remove/{class}','ClassDetailController@remove');
    Route::post('/edit/{class}','ClassDetailController@edit');
    Route::post('/store/','ClassDetailController@store');
    Route::get('/' , 'ClassDetailController@getAllClasses');
});



Route::group(['middleware'=>['auth:api'],'prefix' => 'feeCategory'],function(){
    Route::get('/','FeeCategoryController@index')->name('index');
    Route::post('/store','FeeCategoryController@store')->name('store');
    Route::post('/edit/{fee}','FeeCategoryController@edit')->name('edit');
    Route::post('/destroy{fee}','FeeCategoryController@destroy')->name('destroy');
});


Route::group(['middleware'=>['auth:api'],'prefix' => 'fee'],function(){
    Route::get('/{section}/','FeeController@getFeesStudent');
//    Route::get('/{section}/{student}','FeeController@getStudentFee');
    Route::get('/','FeeController@index')->name('index');
    Route::post('/store/{section}','FeeController@storeOrUpdateSectionFee');
    Route::post('/storefee/{section}/{student}','FeeController@storeOrUpdateStudentFee');
    Route::get('/setupfee/{section}','FeeController@getSectionFee');
    Route::get('/payment/{section}','FeePaymentController@index');
    Route::post('/storepayment/{section}/{student}','FeePaymentController@storePayment');
});

Route::prefix('studentHistory')->group(function(){
    Route::post('/{student}','StudentHistoryController@studentHistoryEvent');
    Route::post('/{student}/{exam}','StudentHistoryController@examHistoryEvent');
});

Route::get('/marksfetch/{section}/{exam}/{rankcal?}','MarkController@getMarksStudent');

Route::get('/get-structure/{exam}/{section}','MarkController@getStructureData');

Route::post('/delete/students','StudentController@deleteStudent');
Route::get('/leave/student/{student}','StudentController@leaveStudent');
Route::get('/demote/student/{student}','StudentController@demoteStudent');
Route::get('/promote/student/{student}','StudentController@promoteStudent');

Route::post('/delete/section_subject','SectionSubjectController@deleteSubject');


