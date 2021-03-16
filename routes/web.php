<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Teacher\TeacherHomeController;
use App\Http\Controllers\Teacher\PaperController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\LaunchQuizController;
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
    Route::get('/profile', [\App\Http\Controllers\Admin\HomeController::class, 'editProfile'])->name('admin.edit.profile');
    Route::post('/profile', [\App\Http\Controllers\Admin\HomeController::class, 'updateProfile'])->name('admin.update.profile');
    Route::get('teacher', [\App\Http\Controllers\Admin\HomeController::class, 'allTeachers'])->name('admin.teacher');
    Route::get('add/teacher', [\App\Http\Controllers\Admin\HomeController::class, 'createTeacher'])->name('admin.teacher.create');
    Route::post('/save/teacher', [\App\Http\Controllers\Admin\HomeController::class, 'storeTeacher'])->name('save.admin.teacher');
    Route::get('/edit/teacher/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'editTeacher'])->name('edit.admin.teacher');
    Route::post('/edit/teacher/{id}', [\App\Http\Controllers\Admin\HomeController::class, 'updateTeacher'])->name('update.admin.teacher');
    Route::delete('/delete/teacher', [\App\Http\Controllers\Admin\HomeController::class, 'deleteTeacher'])->name('delete.admin.teacher');

    // for Students
    Route::get('/students', [\App\Http\Controllers\Admin\StudentController::class, 'students'])->name('admin.all.students');
    Route::get('/create/student', [\App\Http\Controllers\Admin\StudentController::class, 'createStudent'])->name('admin.create.student');
    Route::post('/save/student', [\App\Http\Controllers\Admin\StudentController::class, 'storeStudent'])->name('admin.save.student');
    Route::get('/edit/student/{id}', [\App\Http\Controllers\Admin\StudentController::class, 'editStudent'])->name('admin.edit.student');
    Route::post('/edit/student/{id}', [\App\Http\Controllers\Admin\StudentController::class, 'updateStudent'])->name('admin.update.student');
    Route::delete('/delete/student', [\App\Http\Controllers\Admin\StudentController::class, 'deleteStudent'])->name('admin.delete.student');

    // for calss rooms
    Route::get('/classrooms', [\App\Http\Controllers\Admin\StudentController::class, 'classRooms'])->name('admin.class.room');
    Route::get('/create/classrooms', [\App\Http\Controllers\Admin\StudentController::class, 'createClassRooms'])->name('admin.create.class.room');
    Route::post('/save/classrooms', [\App\Http\Controllers\Admin\StudentController::class, 'storeClassRooms'])->name('admin.save.class.room');
    Route::get('/edit/classrooms/{id}', [\App\Http\Controllers\Admin\StudentController::class, 'editClassRooms'])->name('admin.edit.class.room');
    Route::post('/edit/classrooms/{id}', [\App\Http\Controllers\Admin\StudentController::class, 'updateClassRooms'])->name('admin.update.class.room');
    Route::delete('/delete/classrooms', [\App\Http\Controllers\Admin\StudentController::class, 'deleteClassRooms'])->name('admin.delete.class.room');
    // for Students
    Route::get('/paper', [\App\Http\Controllers\Admin\StudentController::class, 'papers'])->name('admin.all.paper');
    Route::get('/launch/papers', [\App\Http\Controllers\Admin\StudentController::class, 'launchPapers'])->name('admin.launch.paper');
    Route::delete('/delete/paper', [\App\Http\Controllers\Admin\StudentController::class, 'deletePaper'])->name('admin.paper.destroy');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'student'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'editProfile'])->name('user.edit.profile');
    Route::post('/profile', [HomeController::class, 'updateProfile'])->name('user.update.profile');
});


