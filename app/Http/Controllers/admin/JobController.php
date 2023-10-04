<?php

namespace App\Http\Controllers\admin;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.jobs');
    }

    public function get_all(Request $request)
    {
        // dd('bgh');
        $jobs = Job::orderBy('id', 'desc')->paginate($request->per_page);
        // dd($jobs);
        if ($jobs) {
            return response()->json([
                'message' => 'success',
                'data' => $jobs
            ], 200);
        }
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
        if ($request->job_id == 0 && $request->is_editing == false) {
            // dd($request->all());
            if ($request->cover_image) {
                $fileName = time() . '.' . $request->cover_image->getClientOriginalExtension();
                $request->cover_image->move(public_path('assets/img/job_cover_image'), $fileName);
                $cover_image = "assets/img/job_cover_image/" . $fileName;
            }

            $jobs = new Job();
            $jobs->position = $request->position;
            $jobs->slug = $request->slug;
            $jobs->summary = $request->summary;
            $jobs->edu_requirement = $request->edu_requirement;
            $jobs->salary = $request->salary;
            $jobs->published_on = $request->published_on;
            $jobs->vacancy = $request->vacancy;
            $jobs->employment_status = $request->employment_status;
            $jobs->office_time = $request->office_time;
            $jobs->office_days = $request->office_days;
            $jobs->location = $request->location;
            $jobs->experience_req = $request->experience_req;
            $jobs->app_deadline = $request->app_deadline;
            $jobs->applying_url = $request->applying_url;
            $jobs->thumbnail = isset($cover_image) ? $cover_image : '';
            $response = $jobs->save();
            // dd($jobs);
            if ($response) {
                return response()->json([
                    'message' => 'Inserted',
                    'status' => 201,
                    'data' => $jobs
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } else if ($request->job_id != 0) {
            // dd("hello");
            // Job::find($request->job_id);
            if ($request->cover_image) {
                $fileName = time() . '.' . $request->cover_image->getClientOriginalExtension();
                $request->cover_image->move(public_path('assets/img/job_cover_image'), $fileName);
                $cover_image = "assets/img/job_cover_image/" . $fileName;
            }

            $jobs = Job::find($request->job_id);
            $jobs->position = $request->position;
            $jobs->slug = $request->slug;
            $jobs->summary = $request->summary;
            $jobs->edu_requirement = $request->edu_requirement;
            $jobs->salary = $request->salary;
            $jobs->published_on = $request->published_on;
            $jobs->vacancy = $request->vacancy;
            $jobs->employment_status = $request->employment_status;
            $jobs->office_time = $request->office_time;
            $jobs->office_days = $request->office_days;
            $jobs->location = $request->location;
            $jobs->experience_req = $request->experience_req;
            $jobs->app_deadline = $request->app_deadline;
            $jobs->applying_url = $request->applying_url;
            if (isset($cover_image)) {
                $is_exist = file_exists(public_path($jobs->thumbnail));
                if ($jobs->thumbnail !== "") {
                    if ($is_exist == true) {
                        unlink(public_path($jobs->thumbnail));
                        $jobs->thumbnail = $cover_image;
                    }
                } else {
                    $jobs->thumbnail = $cover_image;
                }
            }

            $job = $jobs->save();
            if ($job) {
                return response()->json([
                    'message' => 'Inserted',
                    'status' => 201,
                    'data' => $jobs
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
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
    public function edit($job_id)
    {
        $job = Job::where('id', $job_id)->with(['responsibilities', 'requirements', 'additionals'])->first();
        if ($job) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $job
            ], 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($job_id)
    {
        $job = Job::find($job_id);
        if ($job) {

            $response = $job->delete();
            // dd($response);
            if ($response) {
                return response()->json([
                    'message' => 'Deleted',
                    'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Failed',
                    'status' => 500
                ], 500);
            }
        }
    }
}
