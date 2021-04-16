<?php

namespace App\Http\Controllers\Teacher\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\TrainerRequest;
use App\Mail\VerifyUser;
use App\Models\Teacher;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:teacher')->except('logout');
    }
    public function showRegisterForm(){
        return view('teacher.auth.register');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    /**
     * delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function TeacherRegister1(Request $request)
    {
        if (empty($request->teacher_id)) {
            $RegisterRequest = New TeacherRequest();
            $validator = Validator::make($request->all(), $RegisterRequest->rules(),$RegisterRequest->messages());

            if ($validator->fails()) {
                return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
            }
        }

        try {
            DB::beginTransaction();
            $path = "";
            if($request->hasFile('image')){
                SaveImageAllSizes($request, 'profile/');
                $path = 'profile/'.$request->image->hashName();
            }
            if ($request->teacher_id) {
                $data = Teacher::find($request->teacher_id);
                if ($data) {
                    $update_data = [
                        'name' => $request->firstname . " ". $request->lastname,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'org_password' => $request->password,
                        'profile_photo_path' => !empty($path) ? $path : $data->profile_photo_path,
                        'country' => $request->country,
                        'terms_and_conditions' => $request->terms_and_conditions,
                        'organization_type' => $request->organization_type,
                        'organization_name' => $request->organization_name,
                        'organization_role' => $request->organization_role,
                        //'email_verified_at' =>  Carbon::now(),
                    ];
                    $data->update($update_data);
                }

            } else {
                $class_data = [
                    'name' => $request->firstname . " ". $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'org_password' => $request->password,
                    'profile_photo_path' => !empty($path) ? $path : "default.png",
                    'country' => $request->country,
                    'terms_and_conditions' => $request->terms_and_conditions,
                    'organization_type' => $request->organization_type,
                    'organization_name' => $request->organization_name,
                    'organization_role' => $request->organization_role,
                ];
                $data =  Teacher::create($class_data);
            }

            DB::commit();
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $data);
        } catch ( \Exception $e) {
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

    public function TeacherRegister(TeacherRequest $request)
    {
        //dd($request);
        try {
            DB::beginTransaction();
            $path = "";
            if($request->hasFile('image')){
                SaveImageAllSizes($request, 'profile/');
                $path = 'profile/'.$request->image->hashName();
            }
            $token = uniqid();
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $details = [
                    'title' => 'Account verification',
                    'body' => 'This is for testing email using smtp',
                    'link' => route('verify',["teacher",$token])
                ];
                Mail::to($request->email)->send(new VerifyUser($details));
            }
                $class_data = [
                    'name' => $request->firstname . " ". $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'org_password' => $request->password,
                    'profile_photo_path' => !empty($path) ? $path : "default.png",
                    'country' => $request->country,
                    'terms_and_conditions' => $request->terms_and_conditions,
                    'organization_type' => $request->organization_type,
                    'organization_name' => $request->organization_name,
                    'organization_role' => $request->organization_role,
                    'remember_token' => $token,
                ];
                $data =  Teacher::create($class_data);
            DB::commit();
            return redirect(route('teacher.login'))->with('success', 'Siginup successfully please login.');
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry something went wrong.']);
        }
    }
}
