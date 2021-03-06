<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ClassRoom;
use App\Models\LaunchQuiz;
use App\Models\SubAdmin;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:subadmin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {

        try {

            $current_user = Auth::guard('subadmin')->user();
            $teacher_ids = Teacher::whereSubAdminId($current_user->id)->pluck('id');
            $classes_ids = ClassRoom::whereNull('deleted_at')->whereIn('teacher_id',$teacher_ids)->pluck('id');
            #-------------------- for Test----------------------------------#
            $last_24Hours_Teacher = Teacher::whereSubAdminId($current_user->id)
                ->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereNull('deleted_at')->count();
            $last_7_Days_Teacher = Teacher::whereSubAdminId($current_user->id)
                ->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereNull('deleted_at')->count();
            $life_Time_Teacher = Teacher::whereSubAdminId($current_user->id)
                ->whereNull('deleted_at')->count();
            #-------------------- for ClassRoom----------------------------------#
            $last_24Hours_class = ClassRoom::where('created_at', '>=', \Carbon\Carbon::now()->subDay())
                ->whereIn('teacher_id',$teacher_ids)->whereNull('deleted_at')->count();
            $last_7_Days_class = ClassRoom::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))
                ->whereNull('deleted_at')->whereIn('teacher_id',$teacher_ids)->count();
            $life_Time_class = ClassRoom::whereNull('deleted_at')->whereIn('teacher_id',$teacher_ids)->count();
            #-------------------- for Students----------------------------------#
            $last_24Hours_students = User::where('created_at', '>=', \Carbon\Carbon::now()->subDay())
                ->whereNull('deleted_at')->whereIn('class_room_id',$teacher_ids)->count();
            $last_7_Days_students = User::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))
                ->whereNull('deleted_at')->whereIn('class_room_id',$teacher_ids)->count();
            $life_Time_students = User::whereNull('deleted_at')->whereIn('class_room_id',$teacher_ids)->count();
            #-------------------- for Test----------------------------------#
            $last_24Hours_test = LaunchQuiz::where('created_at', '>=', \Carbon\Carbon::now()->subDay())
                ->whereNull('deleted_at')->whereIn('teacher_id',$teacher_ids)->count();
            $last_7_Days_test = LaunchQuiz::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))
                ->whereNull('deleted_at')->whereIn('teacher_id',$teacher_ids)->count();
            $life_Time_test = LaunchQuiz::whereNull('deleted_at')->whereIn('teacher_id',$teacher_ids)->count();

            return view('subadmin.dashboard',compact(
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
                'life_Time_Teacher'
            ));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('subadmin.home'))->withErrors('Sorry record not found.');
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
            $user = Auth::guard('subadmin')->user();
            return view('subadmin.home.profile',compact('user',));
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
        if(!empty($request->password)){
            $validated = $request->validate([
                'password_confirmation' => 'required|same:password',
            ]);
        }
        if(!empty($request->password_confirmation)){
            $validated = $request->validate([
                'password' => 'required',
            ]);
        }
        try {
            $id = Auth::guard('subadmin')->user()->id;
            $user = SubAdmin::find($id);
            if ($request->hasFile('profile_pic')){
                UpdateImageAllSizes($request, 'profile/', $user->profile_photo_path);
                $path = 'profile/'.$request->profile_pic->hashName();
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => !empty($request->password) ? Hash::make($request->password) : $user->password,
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
