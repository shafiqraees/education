<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
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
            $class_data = [
                'name' => $request->name,
                'email' => $request->email,
                'class_room_id' => $request->class_room,
                'roll_number' => $request->roll_number,
                'is_active' => $request->status,
                'password' => bcrypt($request->password),
                'org_password' => $request->password,
                'profile_photo_path' => !empty($path) ? $path : "",
            ];
            $data =  User::create($class_data);
            DB::commit();
            return redirect(route('all.students'))->with('success', 'Class Room added successfully.');

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }
}
