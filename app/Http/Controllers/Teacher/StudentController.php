<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\ClassRoom;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Unique;

class StudentController extends Controller
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

            $data = User::whereIsActive('true')->whereNull('deleted_at')
                ->whereHas('classRoom',function ($query) use ($id){
                    $query->whereTeacherId($id);
                })->with('classRoom')->orderBy('id','desc')->paginate(10);

            return view('teacher.students.list', compact('data'));

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
            $class = ClassRoom::whereTeacherId($id)->whereStatus('Publish')->whereNull('deleted_at')->get();
            return view('teacher.students.create',compact('class'));

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
    public function store(UserRequest $request)
    {
        try {
            $path = "default.png";
            if($request->hasFile('image')){
                SaveImageAllSizes($request, 'profile/');
                $path = 'profile/'.$request->image->hashName();
            }
            DB::beginTransaction();
            $class_data = [
                'name' => $request->name,
                'email' => $request->email,
                'class_room_id' => $request->class_room,
                'is_active' => $request->status,
                'password' => Hash::make($request->password),
                'org_password' => $request->password,
                'pincode' => rand(11111111, 99999999),
                'profile_photo_path' => !empty($path) ? $path : "",
                'teacher_id' => Auth::guard('teacher')->user()->id,
            ];
            $data =  User::create($class_data);
            DB::commit();
            return redirect(url('/trainer/students'))->with('success', 'Trainee added successfully.');

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
    public function update(Request $request, $id)
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
                return redirect(route('students.index'))->with('success', 'Trainee Group updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry student not found.']);
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
            $ques= User::find($id);
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
    public function deleteQuestion(Request $request)
    {
        try {
            $ques= Question::find($request->id);
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
