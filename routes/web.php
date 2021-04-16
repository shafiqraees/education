<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Teacher\TeacherHomeController;
use App\Http\Controllers\Teacher\PaperController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\LaunchQuizController;
use App\Http\Controllers\Admin\SubAdminController;
use App\Http\Controllers\TraineeController;
use Illuminate\Support\Facades\Auth;
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
    //return view('welcome');
});
/*Route::get('paywithpaypal', [\App\Http\Controllers\PaymentController::class,'payWithPaypal'])->name('paywithpaypal');
Route::post('paypal', [\App\Http\Controllers\PaymentController::class,'postPaymentWithpaypal'])->name('paypal');
Route::get('paypal', [\App\Http\Controllers\PaymentController::class,'getPaymentStatus'])->name('status');*/
/*==================paypal route===============*/
Route::get('/execute-payment', [\App\Http\Controllers\PaymentController::class,'execute']);
Route::post('/create-payment',[ \App\Http\Controllers\PaymentController::class,'create'])->name('create-payment');

Route::get('plan/create',[\App\Http\Controllers\SubscriptionController::class,'createPlan']);

Route::get('plan/list',[\App\Http\Controllers\SubscriptionController::class,'listPlan']);
Route::get('plan/{id}',[\App\Http\Controllers\SubscriptionController::class,'showPlan']);
Route::get('plan/{id}/activate',[\App\Http\Controllers\SubscriptionController::class,'activatePlan']);

Route::post('plan/{id}/agreement/create',[\App\Http\Controllers\SubscriptionController::class,'createAgreement'])->name('create-agreement');
Route::get('execute-agreement/{success}',[\App\Http\Controllers\SubscriptionController::class,'executeAgreement']);
/*==================paypal route===============*/

/*Route::get('payment', [\App\Http\Controllers\PayPalController::class,'payment'])->name('payment');
Route::get('cancel',  [\App\Http\Controllers\PayPalController::class,'cancel'])->name('payment.cancel');
Route::get('payment/success', [\App\Http\Controllers\PayPalController::class,'success'])->name('payment.success');*/

Route::get('/verify/{user}/{token}', [\App\Http\Controllers\Auth\RegisterController::class, 'verifyUser'])->name('verify');
Route::get('trianer/dashboard', [\App\Http\Controllers\Auth\RegisterController::class, 'trainerDashboard'])->name('trianer.dashboard');
Route::post('user/logout', [HomeController::class, 'logOutUser'])->name('logout.user');
Auth::routes();

Route::group(['prefix' => 'trainer'], function () {
    Route::get('/login', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('/login', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'TeacherLogin'])->name('teacher.login.submit');
    Route::post('/logout', [\App\Http\Controllers\Teacher\Auth\LoginController::class, 'logout'])->name('teacher.logout');
    Route::get('/register', [\App\Http\Controllers\Teacher\Auth\RegisterController::class, 'showRegisterForm'])->name('teacher.register');
    Route::post('/register', [\App\Http\Controllers\Teacher\Auth\RegisterController::class, 'TeacherRegister'])->name('teacher.register.store');
});

Route::group(['middleware' => ['auth:teacher'],'prefix' => 'trainer'], function () {
    Route::get('/', [TeacherHomeController::class, 'index'])->name('teacher.home');
    Route::resource('question', \App\Http\Controllers\Teacher\QuestionController::class);
    Route::resource('classrooms', \App\Http\Controllers\Teacher\ClassRoomController::class);
    Route::resource('students', StudentController::class);
    Route::delete('/delete/trainee', [StudentController::class, 'destroy'])->name('trainer.trainee.destroy');
    Route::resource('quiz', PaperController::class);
    Route::get('/result', [PaperController::class, 'result'])->name('result.quiz');
    Route::get('get/options', [PaperController::class, 'getQuestionOptions'])->name('getoption');
    Route::resource('launch', LaunchQuizController::class);
    Route::get('/quiz/attempt/{id}', [LaunchQuizController::class, 'attemptQuiz'])->name('quizattempt');
    Route::get('/trianee/result/{id}', [LaunchQuizController::class, 'trineeResult'])->name('trainee.result');
    Route::get('/profile', [TeacherHomeController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/edit', [TeacherHomeController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/subscription/plan', [TeacherHomeController::class, 'subscriptionPlan'])->name('subs.plan');
    Route::get('get/trainee', [PaperController::class, 'getTrainee'])->name('get.traine');
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
    Route::get('/transaction', [\App\Http\Controllers\Admin\HomeController::class, 'transaction'])->name('transaction');
    Route::get('/launch/quiz', [\App\Http\Controllers\Admin\StudentController::class, 'launchPapers'])->name('admin.launch.quiz');
    Route::delete('/delete/paper', [\App\Http\Controllers\Admin\StudentController::class, 'deletePaper'])->name('admin.paper.destroy');
});

Route::group(['prefix' => 'subadmin'], function () {
    Route::get('/login', [\App\Http\Controllers\SubAdmin\Auth\LoginController::class, 'showLoginForm'])->name('subadmin.login');
    Route::post('/login', [\App\Http\Controllers\SubAdmin\Auth\LoginController::class, 'subAdminLogin'])->name('subadmin.login.submit');
    Route::post('/logout', [\App\Http\Controllers\SubAdmin\Auth\LoginController::class, 'logout'])->name('subadmin.logout');
    Route::get('/register', [\App\Http\Controllers\SubAdmin\Auth\RegisterController::class, 'showRegisterForm'])->name('subadmin.register');
    Route::post('/register', [\App\Http\Controllers\SubAdmin\Auth\RegisterController::class, 'subAdminRegister'])->name('subadmin.register.store');
    Route::post('/verify', [\App\Http\Controllers\SubAdmin\Auth\RegisterController::class, 'subAdminRegister'])->name('subadmin.register.store');
});

Route::group(['middleware' => ['auth:subadmin'], 'prefix' => 'subadmin'], function () {
    Route::get('/', [\App\Http\Controllers\SubAdmin\HomeController::class, 'index'])->name('subadmin.home');
    Route::resource('teachers', \App\Http\Controllers\SubAdmin\TeacherController::class);
    Route::resource('all-class-rooms', \App\Http\Controllers\SubAdmin\ClassRoomController::class);
    Route::resource('all-students', \App\Http\Controllers\SubAdmin\StudentController::class);
    Route::get('/profile', [\App\Http\Controllers\SubAdmin\HomeController::class, 'editProfile'])->name('subadmin.edit.profile');
    Route::post('/profile', [\App\Http\Controllers\SubAdmin\HomeController::class, 'updateProfile'])->name('subadmin.update.profile');
});

Route::group(['prefix' => 'trainee'], function () {
    Route::post('/courseid', [TraineeController::class, 'courseId'])->name('courseid');
    Route::get('/traineeid/{id}', [TraineeController::class, 'getTraineeId'])->name('trainee.id');
    Route::post('/traineekey', [TraineeController::class, 'getTraineeKey'])->name('trainee.key');
    Route::post('/trainee/login', [TraineeController::class, 'TraineeLogin'])->name('trainee.login');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'trainee'], function () {
    Route::get('/', [HomeController::class, 'startQuiz'])->name('home');
    Route::get('/profile', [HomeController::class, 'editProfile'])->name('user.edit.profile');
    Route::get('/quizzes', [HomeController::class, 'startQuiz'])->name('start.quiz');
    Route::post('/quiz/submit', [HomeController::class, 'attemptQuiz'])->name('quiz.save');
    Route::get('/question/answer', [HomeController::class, 'quizAnswer'])->name('quiz.answer');
    Route::get('/quizes', [HomeController::class, 'startQuizes'])->name('start.quizes');
    Route::post('/profile', [HomeController::class, 'updateProfile'])->name('user.update.profile');
});


