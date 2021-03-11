<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\Admin;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\Question;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        try {
            #-------------------- for ClassRoom----------------------------------#
            $last_24Hours_class = ClassRoom::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
            $last_7_Days_class = ClassRoom::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
            $life_Time_class = ClassRoom::whereNull('deleted_at')->count();
            #-------------------- for Students----------------------------------#
            $last_24Hours_students = User::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
            $last_7_Days_students = User::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
            $life_Time_students = User::whereNull('deleted_at')->count();
            #-------------------- for Test----------------------------------#
            $last_24Hours_test = LaunchQuiz::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
            $last_7_Days_test = LaunchQuiz::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
            $life_Time_test = LaunchQuiz::whereNull('deleted_at')->count();
            #-------------------- for Test----------------------------------#
            $last_24Hours_Teacher = Teacher::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
            $last_7_Days_Teacher = Teacher::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
            $life_Time_Teacher = Teacher::whereNull('deleted_at')->count();

            return view('admin.dashboard',compact(
                'last_24Hours_class',
                'last_7_Days_class',
                'life_Time_class',
                'last_24Hours_students',
                'last_7_Days_students',
                'life_Time_students',
                'last_24Hours_test',
                'last_7_Days_test',
                'life_Time_test',
                'last_24Hours_Teacher',
                'last_7_Days_Teacher',
                'life_Time_Teacher',
            ));
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
    public function allTeachers()
    {
        try {
            $data = Teacher::whereNull('deleted_at')->orderBy('id','desc')->paginate(10);

            return view('admin.teacher.list', compact('data'));
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
    public function createTeacher()
    {
        try {
            return view('admin.teacher.create');
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
    public function storeTeacher(StudentRequest $request)
    {
        try {
            if($request->hasFile('image')){
                SaveImageAllSizes($request, 'profile/');
                $path = 'profile/'.$request->image->hashName();
            }
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->status,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'password' => bcrypt($request->password),
                'org_password' => $request->password,
                'profile_photo_path' => !empty($path) ? $path : "",
            ];
            Teacher::create($data);
            DB::commit();
            return redirect(route('admin.teacher'))->with('success', 'Teacher added successfully.');

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
    public function editTeacher($id)
    {

        try {
            $data = Teacher::find($id);
            if ($data) {
                return view('admin.teacher.detail',compact('data'));
            } else {
                return Redirect::back()->withErrors('Sorry teacher not found');
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
    public function updateTeacher(Request $request, $id)
    {
        if(!empty($request->password)){
            $validated = $request->validate([
                'password_confirmation' => 'required|same:password',
            ]);
        }
        try {
            $data = Teacher::find($id);
            if ($data) {
                if($request->hasFile('profile_pic')){
                    UpdateImageAllSizes($request, 'profile/', $data->profile_photo_path);
                    $path = 'profile/'.$request->profile_pic->hashName();
                }
                DB::beginTransaction();
                $user_data = [
                    'name' => !empty($request->name) ? $request->name : $data->name,
                    'is_active' => !empty($request->status) ? $request->status : $data->is_active,
                    'phone' => !empty($request->phone) ? $request->phone : $data->phone,
                    'gender' => !empty($request->gender) ? $request->gender : $data->gender,
                    'password' => !empty($request->password) ? bcrypt($request->password) : $data->password,
                    'org_password' => !empty($request->password) ? $request->password : $data->password,
                    'profile_photo_path' => !empty($path) ? $path : "",
                ];
                $data->update($user_data);
                DB::commit();
                return redirect(route('admin.teacher'))->with('success', 'Teacher updated successfully.');
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
            $user = Auth::guard('admin')->user();
            return view('admin.home.profile',compact('user',));
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

            $id = Auth::guard('admin')->user()->id;
            $user = Admin::find($id);
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
