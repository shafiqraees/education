<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\QuestionOption;
use App\Models\QuestionPaper;
use App\Models\QuestonPapersQuestion;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserQuiz;
use App\Models\UserQuizAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $id =  $user = Auth::user()->id;
            #-------------------- for Test----------------------------------#
            $last_24Hours_test = UserQuizAttempt::whereUserId($id)->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
            $last_7_Days_test = UserQuizAttempt::whereUserId($id)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
            $life_Time_test = UserQuizAttempt::whereUserId($id)->whereNull('deleted_at')->count();

            return view('user.dashboard',compact(
                'last_24Hours_test',
                'last_7_Days_test',
                'life_Time_test'
            ));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editProfile() {
        try {
            $user = Auth::user();
            return view('user.home.profile',compact('user'));
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        if(!empty($request->Password)){
            $validated = $request->validate([
                'password_confirmation' => 'required|same:Password',
            ]);
        }
        try {

            $id = Auth::user()->id;
            $user = User::find($id);
            if ($request->hasFile('profile_pic')){
                UpdateImageAllSizes($request, 'profile/', $user->profile_photo_path);
                $path = 'profile/'.$request->profile_pic->hashName();
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => !empty($request->password) ? bcrypt($request->password) : $user->password,
                'org_password' => !empty($request->password) ? $request->password : $user->password,
                'profile_photo_path' => !empty($path) ? $path : $user->profile_photo_path,
            ];
            $user->update($data);
            //return redirect(route('profile.edit', $user))->with('success', 'Profile updated successfully.');
            return Redirect::back()->with('success','Profile updated successfully');
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function startQuiz() {

        try {

            $currenttime = date("H:i");
            $current_user = Auth::user();
            $launchqiz = LaunchQuiz::whereHas('userQuiz',function ($query) use ($current_user){
                $query->whereUserId($current_user->id);
                })->whereDate('start_datetime',date('Y-m-d'))->first();

            if ($launchqiz) {
                $attempt = UserQuizAttempt::whereUserId($current_user->id)->whereQuestionPaperId($launchqiz->question_paper_id)->get();
                if(!$attempt->isEmpty()){
                    return Redirect::back()->withErrors('You have already attempt Quiz.');
                }
                $startTime = date("H:i", strtotime($launchqiz->start_datetime));
                $endTime = date("H:i", strtotime($launchqiz->end_datetime));
                //if(($startTime == $currenttime) || (($endTime > $currenttime))){
                    $UserQuiz = UserQuiz::whereLaunchQuizId($launchqiz->id)->whereTeacherId($launchqiz->teacher_id)->whereUserId($current_user->id)->first();
                    $data = QuestonPapersQuestion::whereQuestionPaperId($launchqiz->question_paper_id)->whereTeacherId($launchqiz->teacher_id)->inRandomOrder()->first();

                    return view('user.home.attempt',compact('data','UserQuiz'));
                /*} else {
                    return Redirect::back()->withErrors('please wait quiz not start yet.');
                }*/

            } else {
                return Redirect::back()->withErrors('No quiz avialable');
            }


        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attemptQuiz(Request $request)
    {
        $validated = $request->validate([
            'question_option_id' => 'required',
        ]);
        try {
            $user = Auth::user();
            $data = [
                'question_paper_id' => !empty($request->question_paper_id) ? $request->question_paper_id : "",
                'class_room_id' => $user->class_room_id,
                'user_id' => $user->id,
                'question_id' => !empty($request->question_id) ? $request->question_id : "",
                'question_option_id' => !empty($request->question_option_id) ? $request->question_option_id : "",
                'launch_quiz_id' => !empty($request->launch_quiz_id) ? $request->launch_quiz_id : "",
                'user_quiz_id' => !empty($request->user_quiz_id) ? $request->user_quiz_id : "",
            ];
            UserQuizAttempt::create($data);
            return redirect(route('start.quizes',$request->question_paper_id));
            //return Redirect::back()->with('success','Profile updated successfully');
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function startQuizes($id) {


        try {
            $result = 0;
            $current_user = Auth::user();
            $attempt = UserQuizAttempt::whereUserId($current_user->id)->whereQuestionPaperId($id)->pluck('question_id');
            $UserQuiz = UserQuiz::whereUserId($current_user->id)->whereQuestionPaperId($id)->whereHas('questionPaper')->first();
            if ($UserQuiz) {
                $data = QuestonPapersQuestion::whereQuestionPaperId($UserQuiz->question_paper_id)
                    ->whereNotIn('question_id',$attempt)->inRandomOrder()->first();
                if ($data) {
                    return view('user.home.attempt',compact('data','UserQuiz'));
                } else {
                    $attempt_id = UserQuizAttempt::whereUserId($current_user->id)->whereQuestionPaperId($id)->pluck('question_option_id');
                    $attempt = QuestionPaper::whereId($id)->whereHas('question')->withCount('question')->first();
                    $option_data = QuestionOption::where('answer','!=','')->whereIn('id',$attempt_id)->count();
                    if ($option_data){
                        $result =  $option_data/$attempt->question_count*100;
                    }
                    return redirect(route('home'))->with('success','You have got '.$result.' % marks .' );
                }

            } else {
                return Redirect::back()->withErrors('paper completed');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }


}
