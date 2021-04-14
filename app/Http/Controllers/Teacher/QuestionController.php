<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $currrent_id = Auth::guard('teacher')->user()->id;
            $data = Question::whereTeacherId($currrent_id)->whereNull('deleted_at')->orderBy('id','desc')->get();
            return view('teacher.questions.list', compact('data'));

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

            $quiz = Question::whereTeacherId($id)->whereStatus('Publish')->whereNull('deleted_at')->get();
            $number = Question::orderBy('id', 'desc')->first();

            $quiz_number = isset($number->id) ? $number->id : 0 + 1;
            return view('teacher.questions.create',compact('quiz','quiz_number'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('teacher.home'))->withErrors('Sorry record not found.');
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
            'name' => 'required',
        ]);
        //dd($request);
        try {
            if($request->hasFile('photo')){
                SavePhotoAllSizes($request, 'quiz/');
                $quiz_image = 'quiz/'.$request->photo->hashName();
            }
            DB::beginTransaction();
            $serial = 1;
            $que_series = Question::whereTeacherId(Auth::guard('teacher')->user()->id)->max('serial_id');
            $que_series = $que_series + $serial;
            $quiz_data = [
                'name' => $request->name,
                'teacher_id' => Auth::guard('teacher')->user()->id,
                'type' => $request->type,
                'serial_id' => isset($que_series) ? $que_series : "",
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
                    $answer = "";
                    if ($request->answer == $key) {
                        $answer = $request->answer;
                    }
                    //dd($answer);
                    $option_data = [
                        'question_id' => $quiz->id,
                        'suggested_question_id' => $question_ids[$key],
                        'answer' => $answer,
                        'name' => $quiz_option,
                        'image' => !empty($path[$key]) ? $path[$key] : "",
                    ];

                    QuestionOption::create($option_data);
                }
            }
            /*if ($request->type === "Short Answer") {
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
            }*/
            DB::commit();
            return redirect(route('question.index'))->with('success', 'Question added successfully.');

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
            $data = Question::find($id);
            return view('teacher.questions.detail',compact('data'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
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
                /*if ($request->type === "Short Answer") {
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
                }*/
                DB::commit();
                return redirect(route('question.index'))->with('success', 'Question updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry Record not found.']);
        }
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
            $ques = Question::find($id);
            if ($ques) {
                $option = QuestionOption::whereQuestionId($id)->delete();
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
}
