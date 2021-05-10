<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\MethodSetting;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionPaper;
use App\Models\QuestonPapersQuestion;
use App\Models\User;
use App\Traits\Transformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PaperController extends Controller
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
            $data = QuestionPaper::whereTeacherId($id)->whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('teacher.paper.list', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
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
            $data = Question::whereTeacherId($id)->whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('teacher.paper.create', compact('data'));
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
            'paper_name' => 'required',
            'paper_code' => 'required|unique:question_papers',
        ]);
        try {
            DB::beginTransaction();
            $quiz_data = [
                'name' => $request->paper_name,
                'paper_code' => $request->paper_code,
                'teacher_id' => Auth::guard('teacher')->user()->id,
            ];
            // dd($quiz_data);
            $quiz = QuestionPaper::create($quiz_data);
            /*if ($request->quiz_id) {
                foreach ($request->quiz_id as  $quiz_option) {
                    $option_data = [
                        'question_id' => $quiz_option,
                        'teacher_id' => Auth::guard('teacher')->user()->id,
                        'question_paper_id' => $quiz->id,
                    ];
                    QuestonPapersQuestion::create($option_data);
                }
            }*/
            DB::commit();
            return redirect(route('question.create',['id'=>$quiz->id]))->with('success', 'Course created successfully.');
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
        try {
            $teacher_id = Auth::guard('teacher')->user()->id;
            $course = QuestionPaper::find($id);
            $data = Question::whereTeacherId($teacher_id)->whereQuestionPaperId($id)->get();

            return view('teacher.paper.detail', compact('data','course'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('teacher.home'))->withErrors('Sorry record not found.');
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getQuestionOptions(Request $request)
    {

        try {
            $ques= Question::whereTeacherId($request->teacher_id)->whereSerialId($request->id)->first();
            if ($ques) {
                $data = Question::whereTeacherId($request->teacher_id)->whereSerialId($request->id)->whereHas('option')->with(['option'])->first();
                $transformed_data = Transformer::transformOption($data);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_data);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Question not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     * delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePaper(Request $request)
    {
        try {
            $ques= QuestionPaper::find($request->id);
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
     * delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTrainee(Request $request)
    {
        try {
            $ques= User::whereClassRoomId($request->ClassRoom)->whereIsActive('true')->whereNull('deleted_at')->get();
            if ($ques) {
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $ques);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Trainee not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', "something went wrong");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function result()
    {

        try {
            $id = Auth::guard('teacher')->user()->id;
            $data = LaunchQuiz::whereTeacherId($id)->whereNotIn('status',['Arvhive'])->orderBy('id','desc')->get();
            return view('teacher.paper.result', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {

        try {
            $id = Auth::guard('teacher')->user()->id;
            $data = LaunchQuiz::whereTeacherId($id)->where('status','Arvhive')->orderBy('id','desc')->get();
            return view('teacher.paper.archive', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
}
