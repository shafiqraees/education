<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Teacher\TeacherHomeController;
use App\Http\Controllers\Teacher\PaperController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\LaunchQuizController;
use App\Http\Controllers\Admin\SubAdminController;
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
    return view('frontend.index');
});

Auth::routes();

Route::group(['prefix' => 'teacher'], function () {
    Route::get('/login', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('/login', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'TeacherLogin'])->name('teacher.login.submit');
    Route::post('/logout', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'logout'])->name('teacher.logout');
});

Route::group(['middleware' => ['auth:teacher'], 'prefix' => 'teacher'], function () {
    Route::get('/', [TeacherHomeController::class, 'index'])->name('teacher.home');
    Route::resource('question', \App\Http\Controllers\Teacher\QuestionController::class);
    Route::resource('classrooms', \App\Http\Controllers\Teacher\ClassRoomController::class);
    Route::resource('students', StudentController::class);
    Route::resource('quiz', PaperController::class);
    Route::get('get/options', [PaperController::class, 'getQuestionOptions'])->name('getoption');
    Route::resource('launch', LaunchQuizController::class);
    Route::get('/profile', [TeacherHomeController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [TeacherHomeController::class, 'profileUpdate'])->name('profile.update');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'adminLogin'])->name('admin.login.submit');
    Route::post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
});

Route::group(['middleware' => ['auth:admin'], 'prefix' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
    Route::resource('subadmin', SubAdminController::class);
    Route::resource('teacher', \App\Http\Controllers\Admin\TeacherController::class);
    Route::get('/profile', [\App\Http\Controllers\Admin\HomeController::class, 'editProfile'])->name('admin.edit.profile');
    Route::post('/profile', [\App\Http\Controllers\Admin\HomeController::class, 'updateProfile'])->name('admin.update.profile');
    // for Students
    Route::resource('student', \App\Http\Controllers\Admin\StudentsController::class);
    Route::resource('classroom', \App\Http\Controllers\Admin\ClassRoomController::class);
    // for Students
    Route::get('/quiz', [\App\Http\Controllers\Admin\StudentController::class, 'papers'])->name('quiz.all');
    Route::get('/launch/quiz', [\App\Http\Controllers\Admin\StudentController::class, 'launchPapers'])->name('admin.launch.quiz');
    Route::delete('/delete/paper', [\App\Http\Controllers\Admin\StudentController::class, 'deletePaper'])->name('admin.paper.destroy');
});

Route::group(['prefix' => 'subadmin'], function () {
    Route::get('/login', [\App\Http\Controllers\SubAdmin\Auth\LoginController::class, 'showLoginForm'])->name('subadmin.login');
    Route::post('/login', [\App\Http\Controllers\SubAdmin\Auth\LoginController::class, 'subAdminLogin'])->name('subadmin.login.submit');
    Route::post('/logout', [\App\Http\Controllers\SubAdmin\Auth\LoginController::class, 'logout'])->name('subadmin.logout');
});

Route::group(['middleware' => ['auth:subadmin'], 'prefix' => 'subadmin'], function () {
    Route::get('/', [\App\Http\Controllers\SubAdmin\HomeController::class, 'index'])->name('subadmin.home');
    Route::resource('teachers', \App\Http\Controllers\SubAdmin\TeacherController::class);
    Route::resource('all-class-rooms', \App\Http\Controllers\SubAdmin\ClassRoomController::class);
    Route::resource('all-students', \App\Http\Controllers\SubAdmin\StudentController::class);
    Route::get('/profile', [\App\Http\Controllers\SubAdmin\HomeController::class, 'editProfile'])->name('subadmin.edit.profile');
    Route::post('/profile', [\App\Http\Controllers\SubAdmin\HomeController::class, 'updateProfile'])->name('subadmin.update.profile');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'student'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'editProfile'])->name('user.edit.profile');
    Route::get('/quizzes', [HomeController::class, 'startQuiz'])->name('start.quiz');
    Route::post('/quiz/submit', [HomeController::class, 'attemptQuiz'])->name('quiz.save');
    Route::get('/quizes/{id}', [HomeController::class, 'startQuizes'])->name('start.quizes');
    Route::post('/profile', [HomeController::class, 'updateProfile'])->name('user.update.profile');
});


