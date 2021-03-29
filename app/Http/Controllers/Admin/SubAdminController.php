<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubAdminRequest;
use App\Http\Requests\TeacherRequest;
use App\Mail\VerifyUser;
use App\Models\SubAdmin;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\DataTables;

class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = SubAdmin::whereNull('deleted_at')->orderBy('id','desc')->get();
            /*if ($request->ajax()) {
                $data = SubAdmin::whereNull('deleted_at')->orderBy('id','desc')->get();

                return Datatables::of($data)

                    ->addIndexColumn()
                    ->editColumn('created_at', function ($user) {

                        return [

                            'display' => e($user->created_at->format('m/d/Y')),

                            'timestamp' => $user->created_at->timestamp

                        ];

                    })
                    ->addColumn('action', function($row){

                        $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                        return $actionBtn;
                    })

                    ->rawColumns(['action'])
                    ->make(true);

            }*/

            return view('admin.subadmin.list', compact('data'));
            //return view('admin.subadmin.ajaxlist');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('admin.home'))->withErrors('Sorry record not found.');
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
            return view('admin.subadmin.create');
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
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required|confirmed|min:8',
            'email' => 'unique:subadmins',
        ]);
        try {
            $path = "default.png";
            if($request->hasFile('image')){
                SaveImageAllSizes($request, 'profile/');
                $path = 'profile/'.$request->image->hashName();
            }
            DB::beginTransaction();
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $token = uniqid();
                $details = [
                    'title' => 'Account verification',
                    'body' => 'This is for testing email using smtp',
                    'link' => route('verify',["subadmin",$token])
                ];
                Mail::to($request->email)->send(new VerifyUser($details));
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'is_active' => $request->status,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'password' => bcrypt($request->password),
                'org_password' => $request->password,
                'profile_photo_path' => !empty($path) ? $path : "default.png",
                'remember_token' => $token,
            ];
            SubAdmin::create($data);
            DB::commit();
            return redirect(route('subadmin.index'))->with('success', 'Sub Admin added successfully.');

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
            $data = SubAdmin::find($id);
            if ($data) {
                return view('admin.subadmin.detail',compact('data'));
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
            $data = SubAdmin::find($id);
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
                return redirect(route('subadmin.index'))->with('success', 'Teacher updated successfully.');
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
            $ques= SubAdmin::find($id);
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
