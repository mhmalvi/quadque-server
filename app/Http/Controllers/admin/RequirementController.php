<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
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
    public function store(Request $request, $job_id)
    {
        if ($request[0]['requirement']) {
            $response = [];
            $requirements = Requirement::where('job_id', $job_id)->get();
            if ($requirements) {
                foreach ($requirements as $data) {
                    $data->delete();
                }
                foreach ($request->all() as $data) {
                    $data = Requirement::updateOrCreate([
                        'requirement' => $data['requirement'],
                        'job_id' => $job_id
                    ]);
                    array_push($response, $data);
                }
                if (count($response) > 0) {
                    return response()->json([
                        'message' => 'success',
                        'status' => 201,
                        'data' => $response
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'Failed',
                        'status' => 500
                    ], 500);
                }
            } else {
                foreach ($request->all() as $data) {
                    $data = Requirement::updateOrCreate([
                        'requirement' => $data['requirements'],
                        'job_id' => $job_id
                    ]);
                    array_push($response, $data);
                }
                if (count($response) > 0) {
                    return response()->json([
                        'message' => 'success',
                        'status' => 201,
                        'data' => $response
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'Failed',
                        'status' => 500
                    ], 500);
                }
            }
        } else {
            return response()->json([
                'message' => 'Requirements required',
                'status' => 422
            ], 422);
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
}
