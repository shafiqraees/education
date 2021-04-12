<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Admin;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
class TraineeController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function courseId(Request $request)
    {
        $validated = $request->validate([
            'course_coude' => 'required',
        ]);

        try {
            $room = ClassRoom::whereClassCode($request->course_coude)->whereStatus('publish')->whereNull('deleted_at')->first();
            if ($room){
                return redirect(route('trainee.id', $room->id))->with('success', 'Profile updated successfully.');
                //return Redirect::back()->with('success','Profile updated successfully');
            } else {
                return Redirect::back()->with('error','Sorry Room not found');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors('Sorry Record not found');
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTraineeId($id) {
        try {
            $room = ClassRoom::find($id);
           // dd($room);
            return view('auth.verify',compact('room'));
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
    public function getTraineeKey(Request $request)
    {
        $validated = $request->validate([
            'pin_code' => 'required',
        ]);
        try {
            $user = User::wherePincode($request->pin_code)->whereIsActive('true')->whereNull('deleted_at')->first();

            if ($user){
               // return redirect(route('trainee.name', $user->id))->with('success', 'Profile updated successfully.');
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $user);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Trainee not found');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', 'Sorry server not respond');
        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function TraineeLogin(Request $request) {

        try {
            $user = User::find($request->id);

            if ($user) {
                $credentials = [
                    'email' => $user->email, 'password' => $user->org_password,
                    'is_active' => 'true'
                ];
                if (auth()->attempt($credentials)) {
                   return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $user);

                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Your Pin is incorrect');
                }
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Trainee not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', 'Something went wrong');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function quizAnswer(Request $request) {

        try {
            $user = User::find($request->id);

            if ($user) {
                $credentials = [
                    'email' => $user->email, 'password' => $user->org_password,
                    'is_active' => 'true'
                ];
                if (auth()->attempt($credentials)) {
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $user);

                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Your Pin is incorrect');
                }
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Trainee not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', 'Something went wrong');
        }
    }
}
