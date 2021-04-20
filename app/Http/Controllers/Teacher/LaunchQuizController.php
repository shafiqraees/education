<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\MethodSetting;
use App\Models\QuestionPaper;
use App\Models\User;
use App\Models\UserQuiz;
use App\Models\UserQuizAttempt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Mail\SendQuizNotification;

class LaunchQuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:teacher');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $id = Auth::guard('teacher')->user()->id;

            $data = LaunchQuiz::whereTeacherId($id)->orderBy('id','desc')->paginate(10);

            return view('teacher.launchPaper.list', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('teacher.home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $id = Auth::guard('teacher')->user()->id;
            $data = ClassRoom::whereStatus('Publish')->whereTeacherId($id)->whereNull('deleted_at')->orderBy('id','desc')->get();
            $papers = QuestionPaper::whereTeacherId($id)->whereStatus('Publish')->whereNull('deleted_at')->orderBy('id','desc')->get();
            return view('teacher.launchPaper.create', compact('data','papers'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paper_id' => 'required',
            'class_room' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
        ]);
        //dd($request);
        try {
            $students = User::whereClassRoomId($request->class_room)->whereIsActive('true')
                ->whereNull('deleted_at')->select('id','email')->get();
            $class_room = QuestionPaper::find($request->paper_id);
            DB::beginTransaction();
            if(!$students->isEmpty()) {
                $quiz_data = [
                    'class_room_id' => $request->class_room,
                    'question_paper_id' => $request->paper_id,
                    'start_datetime' => date('Y-m-d H:i:s', strtotime($request->start_datetime)),
                    'end_datetime' => date('Y-m-d H:i:s', strtotime($request->end_datetime)),
                    'teacher_id' => Auth::guard('teacher')->user()->id,
                ];
                // dd($quiz_data);
                $quiz = LaunchQuiz::create($quiz_data);
                if ($request->setting) {
                    foreach ($request->setting as  $quiz_option) {
                        $option_data = [
                            'name' => $quiz_option,
                            'launch_quizze_id' => $quiz->id,
                        ];
                        MethodSetting::create($option_data);
                    }
                }
                foreach ($students as $student) {
                    $user_data = [
                        'teacher_id' => Auth::guard('teacher')->user()->id,
                        'question_paper_id' => $request->paper_id,
                        'class_room_id' => $request->class_room,
                        'user_id' => $student->id,
                        'launch_quiz_id' => $quiz->id,
                    ];
                    UserQuiz::create($user_data);

                    if (filter_var($student->email, FILTER_VALIDATE_EMAIL)) {
                        $details = [
                            'title' => 'Mail from educatio',
                            'body' => 'This is for testing email using smtp',
                            'Course_Code' => $class_room->paper_code,
                            'Pin' => $student->pincode,
                        ];
                        Mail::to($student->email)->send(new SendQuizNotification($details));
                    }
                }
                DB::commit();
                return redirect(route('result.quiz'))->with('success', 'Quiz launch successfully.');
            } else {
                DB::rollBack();
                return Redirect::back()->withErrors('Please first add Students selected calss');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ques= LaunchQuiz::find($id);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function QuizPutToArchive($id)
    {
        try {
            $ques= LaunchQuiz::find($id);
            if ($ques) {
                $archive = [
                    'status' => 'Arvhive',
                ];
                $data = $ques->update($archive);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiveRevrt($id)
    {
        try {
            $ques= LaunchQuiz::find($id);
            if ($ques) {
                $archive = [
                    'status' => 'Unarchive',
                ];
                $data = $ques->update($archive);
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function attemptQuiz($id)
    {
        try {
            $data = User::whereHas('userAttemptQuiz',function ($query) use ($id) {
                $query->where('launch_quiz_id',$id);
            })->with('userAttemptQuiz',function ($query){
                $query->with('quizPaper',function ($query){
                    $query->withCount('questionPaperquestion');
                });
            })->get();
           // dd($data);

            return view('teacher.launchPaper.attempt',compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('teacher.home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trineeResult($id)
    {
        try {
            $data = User::whereHas('userAttemptQuiz',function ($query) use ($id) {
                $query->where('launch_quiz_id',$id);
            })->with('userAttemptQuiz',function ($query){
                $query->with('quizPaper',function ($query){
                    $query->withCount('questionPaperquestion');
                });
            })->get();
           // dd($data);

            return view('teacher.launchPaper.trainee_result',compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('teacher.home'))->withErrors('Sorry record not found.');
        }
    }
}
