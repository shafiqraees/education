<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\Transformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class TeacherHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $id = Auth::guard('teacher')->user()->id;
        #-------------------- for ClassRoom----------------------------------#
        $last_24Hours_class = ClassRoom::whereTeacherId($id)->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
        $last_7_Days_class = ClassRoom::whereTeacherId($id)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
        $life_Time_class = ClassRoom::whereTeacherId($id)->whereNull('deleted_at')->count();
        #-------------------- for Students----------------------------------#
        $last_24Hours_students = User::whereTeacherId($id)->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
        $last_7_Days_students = User::whereTeacherId($id)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
        $life_Time_students = User::whereTeacherId($id)->whereNull('deleted_at')->count();
        #-------------------- for Test----------------------------------#
        $last_24Hours_test = LaunchQuiz::whereTeacherId($id)->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
        $last_7_Days_test = LaunchQuiz::whereTeacherId($id)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
        $life_Time_test = LaunchQuiz::whereTeacherId($id)->whereNull('deleted_at')->count();

        return view('teacher.dashboard',compact(
            'last_24Hours_class',
            'last_7_Days_class',
            'life_Time_class',
            'last_24Hours_students',
            'last_7_Days_students',
            'life_Time_students',
            'last_24Hours_test',
            'last_7_Days_test',
            'life_Time_test',
        ));
    }
    /**
     * Show the application qustions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function questions() {

        try {
            $currrent_id = Auth::guard('teacher')->user()->id;
            $data = Question::whereTeacherId($currrent_id)->whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('teacher.questions.list', compact('data'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * Show the create Question.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createQuestion() {
        $id = Auth::guard('teacher')->user()->id;
        $quiz = Question::whereTeacherId($id)->whereStatus('Publish')->whereNull('deleted_at')->get();
        $number = Question::orderBy('id', 'desc')->first()->id;
        $quiz_number = $number + 1;
        return view('teacher.questions.create',compact('quiz','quiz_number'));
    }

    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function storeQuestion(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'marks' => 'required',
        ]);

        try {
            if($request->hasFile('photo')){
                SavePhotoAllSizes($request, 'quiz/');
                $quiz_image = 'quiz/'.$request->photo->hashName();
            }
            DB::beginTransaction();
            $quiz_data = [
                'name' => $request->name,
                'teacher_id' => Auth::guard('teacher')->user()->id,
                'status' => $request->status,
                'marks' => $request->marks,
                'type' => $request->type,
                'image' => !empty($quiz_image) ? $quiz_image : "",
                'questio_code' => Hash::make($request->name.time()),
            ];
           // dd($quiz_data);
            if($request->hasFile('image')){
                $files = $request->file('image');
                $path = [];
                foreach ($files as $file) {
                    SaveBannerAllSizes($file, 'quiz_options/');
                    $path[] .= 'quiz_options/'.$file->hashName();
                }
            }
            $quiz = Question::create($quiz_data);
            if ($request->type === "Multiple Choice") {
                $question_ids = $request->question_id;
                foreach ($request->option as  $key => $quiz_option) {
                    if ($request->answer == $key) {
                        $answer = $request->answer;
                    }
                    $option_data = [
                        'question_id' => $quiz->id,
                        'suggested_question_id' => $question_ids[$key],
                        'answer' => !empty($answer) ? $answer : "",
                        'name' => $quiz_option,
                        'image' => !empty($path[$key]) ? $path[$key] : "",
                    ];
                    QuestionOption::create($option_data);
                }
            }
            if ($request->type === "Short Answer") {
                    $option_data = [
                        'question_id' => $quiz->id,
                        'suggested_question_id' => $request->Short_question_id,
                        'answer' => $request->ShortAnswer,
                    ];
                    QuestionOption::create($option_data);
            }
            if ($request->type === "True/False") {
                    $option_data = [
                        'question_id' => $quiz->id,
                        'suggested_question_id' => $request->true_false_question_id,
                        'answer' => $request->truefalse,
                    ];
                    QuestionOption::create($option_data);
            }
            DB::commit();
            return redirect(route('all.queston'))->with('success', 'Question added successfully.');

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     * Show the create Question.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editQuestion($id) {
        $data = Question::find($id);

        return view('teacher.questions.detail',compact('data'));
    }

    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function updateQuestion(Request $request,$id)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        try {
            $data = Question::find($id);
            if($request->hasFile('photo')){
                UpdatePhotoAllSizes($request, 'quiz/', $data->image);
                $path = 'quiz/'.$request->photo->hashName();
            }
            if ($data) {
                DB::beginTransaction();
                $cat_data = [
                    'name' => !empty($request->name) ? $request->name : $data->name,
                    'teacher_id' => Auth::guard('teacher')->user()->id,
                    'status' => !empty($request->status) ? $request->status : $data->status,
                    'marks' => !empty($request->marks) ? $request->marks : $data->marks,
                    'type' => !empty($request->type) ? $request->type : $data->type,
                ];
                $data->update($cat_data);
                $option_data = QuestionOption::whereQuestionId($id)->get();

                if ($option_data) {
                    QuestionOption::whereQuestionId($id)->delete();
                }
                if ($request->type === "Multiple Choice") {
                    $question_ids = $request->question_id;
                    foreach ($request->option as  $key => $quiz_option) {
                        if ($request->answer == $key) {
                            $answer = $request->answer;
                        }
                        $option_data = [
                            'question_id' => $id,
                            'suggested_question_id' => $question_ids[$key],
                            'answer' => !empty($answer) ? $answer : "",
                            'name' => $quiz_option,
                            'image' => !empty($path[$key]) ? $path[$key] : "",
                        ];
                        QuestionOption::create($option_data);
                    }
                }
                if ($request->type === "Short Answer") {
                    $option_data = [
                        'question_id' => $id,
                        'suggested_question_id' => $request->Short_question_id,
                        'answer' => $request->ShortAnswer,
                    ];
                    QuestionOption::create($option_data);
                }
                if ($request->type === "True/False") {
                    $option_data = [
                        'question_id' => $id,
                        'suggested_question_id' => $request->true_false_question_id,
                        'answer' => $request->truefalse,
                    ];
                    QuestionOption::create($option_data);
                }
                DB::commit();
                return redirect(route('all.queston'))->with('success', 'Question updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry Record not found.']);
        }
    }

    /**
     * Show the application qustions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function classRooms() {
        try {
            $data = ClassRoom::whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('teacher.classrooms.list', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * Show the create Question.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createClassRooms() {
        return view('teacher.classrooms.create');
    }

    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function storeClassRooms(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'class_code' => 'unique:class_rooms',
        ]);

        try {
            DB::beginTransaction();
            $class_data = [
                'name' => $request->name,
                'status' => $request->status,
                'class_code' => $request->class_code,
            ];
            // dd($quiz_data);
            ClassRoom::create($class_data);
            DB::commit();
            return redirect(route('all.class.room'))->with('success', 'Class Room added successfully.');

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     * Show the create Question.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editClassRooms($id) {
        try {
            $data = ClassRoom::find($id);
            return view('teacher.classrooms.detail',compact('data'));
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function updateClassRooms(Request $request,$id)
    {
        try {
            $data = ClassRoom::find($id);
            if ($data) {
                DB::beginTransaction();
                $cat_data = [
                    'status' => !empty($request->status) ? $request->status : $data->status,
                ];
                $data->update($cat_data);
                DB::commit();
                return redirect(route('all.class.room'))->with('success', 'Class room updated successfully.');
                //return Redirect::back()->with('success', 'Interest updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry Record not found.']);
        }
    }
    /**
     * delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteClassRooms(Request $request)
    {
        try {
            $ques= ClassRoom::find($request->id);
            if ($ques) {
                $data = $ques->delete();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $data);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Question not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     * Show the application qustions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function students() {
        try {

            $data = User::whereIsActive('true')->whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('teacher.students.list', compact('data'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * Show the create Question.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createStudent() {
        $class = ClassRoom::whereStatus('Publish')->whereNull('deleted_at')->get();
        return view('teacher.students.create',compact('class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStudent(StudentRequest $request)
    {

        try {
            if($request->hasFile('image')){
                SaveImageAllSizes($request, 'profile/');
                $path = 'profile/'.$request->image->hashName();
            }
            DB::beginTransaction();
            $class_data = [
                'name' => $request->name,
                'email' => $request->email,
                'class_room_id' => $request->class_room,
                'roll_number' => $request->roll_number,
                'is_active' => $request->status,
                'password' => bcrypt($request->password),
                'org_password' => $request->password,
                'profile_photo_path' => !empty($path) ? $path : "",
                'teacher_id' => Auth::guard('teacher')->user()->id,
            ];
            $data =  User::create($class_data);
            DB::commit();
            return redirect(route('all.students'))->with('success', 'Class Room added successfully.');

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editStudent($id)
    {

        try {
            $data = User::find($id);
            if ($data) {
                $class = ClassRoom::whereStatus('Publish')->whereNull('deleted_at')->get();
                return view('teacher.students.detail',compact('data','class'));
            } else {
                return Redirect::back()->withErrors('Sorry user not found');
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
    public function updateStudent(Request $request, $id)
    {
        if(!empty($request->password)){
            $validated = $request->validate([
                'password_confirmation' => 'required|same:password',
            ]);
        }
        try {
            $data = User::find($id);
            if ($data) {
                if($request->hasFile('profile_pic')){
                    UpdateImageAllSizes($request, 'profile/', $data->profile_photo_path);
                    $path = 'profile/'.$request->profile_pic->hashName();
                }
                DB::beginTransaction();
                $user_data = [
                    'name' => $request->name,
                    'class_room_id' => $request->class_room,
                    'is_active' => !empty($request->status) ? $request->status : $data->is_active,
                    'profile_photo_path' => !empty($path) ? $path : $data->profile_photo_path,
                    'password' => !empty($request->Password) ? bcrypt($request->Password) : $data->password,
                ];
                $data->update($user_data);
                DB::commit();
                return redirect(route('all.students'))->with('success', 'Class room updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry student not found.']);
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry Record not found.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {

        try {
            $user = Auth::guard('teacher')->user();
            return view('teacher.home.profile',compact('user',));
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
    public function profileUpdate(Request $request)
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

            $id = Auth::guard('teacher')->user()->id;
            $user = Teacher::find($id);
            if ($request->hasFile('profile_pic')){
                UpdateImageAllSizes($request, 'profile/', $user->profile_photo_path);
                $path = 'profile/'.$request->profile_pic->hashName();
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => !empty($request->Password) ? bcrypt($request->Password) : $user->password,
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
}
