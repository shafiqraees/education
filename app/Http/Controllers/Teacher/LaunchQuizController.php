<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\MethodSetting;
use App\Models\QuestionPaper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LaunchQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $data = LaunchQuiz::orderBy('id','desc')->paginate(10);
            return view('teacher.launchPaper.List', compact('data'));
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
            $data = ClassRoom::whereStatus('Publish')->whereNull('deleted_at')->orderBy('id','desc')->get();
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
        ]);

        try {
            DB::beginTransaction();
            $quiz_data = [
                'class_room_id' => $request->class_room,
                'question_paper_id' => $request->paper_id,
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
            DB::commit();
            return redirect(route('launch.index'))->with('success', 'Quiz launch successfully.');
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
}
