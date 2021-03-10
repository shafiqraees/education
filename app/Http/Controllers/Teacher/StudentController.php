<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteStudent(Request $request)
    {
        try {
            $ques= User::find($request->id);
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
