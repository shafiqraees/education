<?php

namespace App\Http\Controllers\SubAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Models\SubAdmin;
use App\Models\Teacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $id = Auth::guard('subadmin')->user()->id;
            $data = Teacher::whereSubAdminId($id)->whereHas('subAdmin')->with('subAdmin')->whereNull('deleted_at')->orderBy('id','desc')->paginate(10);
            return view('subadmin.teacher.list', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
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
            return view('subadmin.teacher.create');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeacherRequest $request)
    {
        try {
            $path = "default.png";
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
                'sub_admin_id' => $id = Auth::guard('subadmin')->user()->id,
            ];
            Teacher::create($data);
            DB::commit();
            return redirect(route('teachers.index'))->with('success', 'Teacher added successfully.');

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
            $data = Teacher::find($id);
            if ($data) {
                return view('subadmin.teacher.detail',compact('data'));
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
    public function update(Request $request, $id)
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
                    'profile_photo_path' => !empty($path) ? $path : $data->profile_photo_path,
                ];
                $data->update($user_data);
                DB::commit();
                return redirect(route('teachers.index'))->with('success', 'Teacher updated successfully.');
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
            $ques= Teacher::find($id);
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
