<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\QuestionPaper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    /**
     * Show the application qustions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function students() {
        try {
            $data = User::whereIsActive('true')->whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('admin.students.list', compact('data'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     * Show the application qustions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createStudent() {
        try {
            $class = ClassRoom::whereStatus('Publish')->whereNull('deleted_at')->get();
            return view('admin.students.create',compact('class'));

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
                'admin_id' => Auth::guard('admin')->user()->id,
                'org_password' => $request->password,
                'profile_photo_path' => !empty($path) ? $path : "",
            ];
            $data =  User::create($class_data);
            DB::commit();
            return redirect(route('admin.all.students'))->with('success', 'Student added successfully.');

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
                return view('admin.students.detail',compact('data','class'));
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
                    'password' => !empty($request->password) ? bcrypt($request->password) : $data->password,
                    'org_password' => !empty($request->password) ? $request->password : $data->password,
                ];
                $data->update($user_data);
                DB::commit();
                return redirect(route('admin.all.students'))->with('success', 'Student updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry student not found.']);
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
            return view('admin.classrooms.list', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * Show the application qustions.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createClassRooms() {
        try {
            return view('admin.classrooms.create');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
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
                'admin_id' => Auth::guard('admin')->user()->id,
            ];
            // dd($quiz_data);
            ClassRoom::create($class_data);
            DB::commit();
            return redirect(route('admin.class.room'))->with('success', 'Class Room added successfully.');

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
            return view('admin.classrooms.detail',compact('data'));
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
                return redirect(route('admin.class.room'))->with('success', 'Class room updated successfully.');
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function papers()
    {
        try {
            $data = QuestionPaper::whereStatus('Publish')->whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('admin.paper.list', compact('data'));
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
    public function launchPapers()
    {
        try {
            $data = LaunchQuiz::whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('admin.paper.launch_list', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
}
