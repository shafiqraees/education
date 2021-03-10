<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Teacher\TeacherHomeController;
use App\Http\Controllers\Teacher\PaperController;
use App\Http\Controllers\Teacher\StudentController;
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

Route::get('/', function () {
    return redirect(route('login'));
});
Auth::routes();
Route::namespace("Teacher")->prefix('teacher')->group(function(){
    Route::get('/', [TeacherHomeController::class, 'index'])->name('teacher.home');
    Route::namespace('Auth')->group(function(){
        Route::get('/login', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'showLoginForm'])->name('teacher.login');
        Route::post('/login', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'TeacherLogin'])->name('teacher.login.submit');
        Route::post('/logout', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'logout'])->name('teacher.logout');
    });
    Route::get('/question', [TeacherHomeController::class, 'questions'])->name('all.queston');
    Route::get('/create/question', [TeacherHomeController::class, 'createQuestion'])->name('create.question');
    Route::post('/save/question', [TeacherHomeController::class, 'storeQuestion'])->name('save.question');
    Route::get('/edit/question/{id}', [TeacherHomeController::class, 'editQuestion'])->name('edit.question');
    Route::post('/edit/question/{id}', [TeacherHomeController::class, 'updateQuestion'])->name('update.question');
    Route::delete('/delete/question', [StudentController::class, 'deleteQuestion'])->name('delete.question');
    // for calss rooms
    Route::get('/classrooms', [TeacherHomeController::class, 'classRooms'])->name('all.class.room');
    Route::get('/create/classrooms', [TeacherHomeController::class, 'createClassRooms'])->name('create.class.room');
    Route::post('/save/classrooms', [TeacherHomeController::class, 'storeClassRooms'])->name('save.class.room');
    Route::get('/edit/classrooms/{id}', [TeacherHomeController::class, 'editClassRooms'])->name('edit.class.room');
    Route::post('/edit/classrooms/{id}', [TeacherHomeController::class, 'updateClassRooms'])->name('update.class.room');
    Route::delete('/delete/classrooms', [TeacherHomeController::class, 'deleteClassRooms'])->name('delete.class.room');
    // for Students
    Route::get('/students', [TeacherHomeController::class, 'students'])->name('all.students');
    Route::get('/create/student', [TeacherHomeController::class, 'createStudent'])->name('create.student');
    Route::post('/save/student', [TeacherHomeController::class, 'storeStudent'])->name('save.student');
    Route::get('/edit/student/{id}', [TeacherHomeController::class, 'editStudent'])->name('edit.student');
    Route::post('/edit/student/{id}', [TeacherHomeController::class, 'updateStudent'])->name('update.student');
    Route::delete('/delete/student', [StudentController::class, 'deleteStudent'])->name('delete.student');
    // for Students
    Route::get('/paper', [PaperController::class, 'index'])->name('all.paper');
    Route::get('/create/paper', [PaperController::class, 'create'])->name('paper.create');
    Route::post('/save/paper', [PaperController::class, 'storePaper'])->name('paper.store');
    Route::get('/edit/paper/{id}', [TeacherHomeController::class, 'editPaper'])->name('paper.edit');
    Route::post('/edit/paper/{id}', [TeacherHomeController::class, 'updatePaper'])->name('paper.update');
    Route::delete('/delete/paper', [PaperController::class, 'deletePaper'])->name('paper.destroy');
    Route::get('get/options', [PaperController::class, 'getQuestionOptions'])->name('getoption');
    // for Quiz
    Route::get('/launch/quiz', [PaperController::class, 'launchQuizIndex'])->name('launch.quiz');
    Route::get('/create/launch/quiz', [PaperController::class, 'launchQuizCreate'])->name('launch.quiz.create');
    Route::post('/save/launch/quiz', [PaperController::class, 'storeLaunchQuiz'])->name('launch.quiz.store');
    Route::delete('/delete/launch/quiz', [PaperController::class, 'deleteLaunchQuiz'])->name('launch.quiz.destroy');

    // for Profile
    Route::get('/profile', [TeacherHomeController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [TeacherHomeController::class, 'profileUpdate'])->name('profile.update');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'user'], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'editProfile'])->name('edit.profile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update.profile');
    Route::get('/marketing', [HomeController::class, 'marketing'])->name('marketer.marketing');
    Route::get('/add/detail/{id}', [HomeController::class, 'addDetail'])->name('add.detail');
    Route::get('/create/add', [HomeController::class, 'createAdd'])->name('create.add');
    Route::post('/mach/audience', [HomeController::class, 'machAudience'])->name('audience');
    Route::post('/create/save', [HomeController::class, 'saveAdd'])->name('save.add');
    Route::post('/status/update/{id}', [HomeController::class, 'addStatusUpdate'])->name('addstatus.update');
    #-------------------- marketer routes add by WOL-17------------------------------#
    Route::get('/buycredits'  , [HomeController::class, 'buycreditslist'])->name('buyredits');
    Route::get('/selectedpackage/{id}', [HomeController::class, 'selectedpackage'])->name('selected.package');
    Route::get('/cancelpayfastrequest'  , [HomeController::class, 'cancelpayfastcreditrequest'])->name('payfast.cancel');
    Route::get('/notify'  , [HomeController::class, 'notifypayfast']);
    Route::get('/transactions', [HomeController::class, 'usertransactions'])->name('transactions');
    Route::get('/transactiondetail/{id}', [HomeController::class, 'transactiondetail'])->name('transaction-detail');
    Route::get('under-construction', [HomeController::class, 'underConstrut'])->name('under-cons');
    Route::get('analytical/marketing', [HomeController::class, 'analyticalMarketing'])->name('analytical.marketing');
    Route::get('marketing/compaign', [HomeController::class, 'marketingCompaign'])->name('marketing.report');
});


