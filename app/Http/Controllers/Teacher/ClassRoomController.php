<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ClassRoomController extends Controller
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
            $data = ClassRoom::whereNull('deleted_at')->whereTeacherId($id)->orderBy('id','desc')->paginate(10);
            return view('teacher.classrooms.list', compact('data'));
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
            return view('teacher.classrooms.create');
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
            'name' => 'required',
            'class_code' => 'unique:class_rooms',
        ]);
        try {
            DB::beginTransaction();
            $class_data = [
                'name' => $request->name,
                'status' => $request->status,
                'class_code' => $request->class_code,
                'teacher_id' => Auth::guard('teacher')->user()->id,
            ];
            // dd($quiz_data);
            ClassRoom::create($class_data);
            DB::commit();
            return redirect(route('classrooms.index'))->with('success', 'Class Room added successfully.');

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
            $data = ClassRoom::find($id);
            return view('teacher.classrooms.detail',compact('data'));
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
    public function update(Request $request, $id)
    {
        try {
            $data = ClassRoom::find($id);
            if ($data) {
                DB::beginTransaction();
                $cat_data = [
                    'status' => !empty($request->status) ? $request->status : $data->status,
                    'name' => !empty($request->name) ? $request->name : $data->name,
                ];
                $data->update($cat_data);
                DB::commit();
                return redirect(route('classrooms.index'))->with('success', 'Class room updated successfully.');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ques = ClassRoom::find($id);
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
