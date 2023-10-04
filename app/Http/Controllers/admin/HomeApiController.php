<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\HomeVideo;

class HomeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function counter()
    {
        try {
            $counter = Counter::find(1);
            $counter->counter = $counter->counter + 1;
            $save = $counter->save();
            if ($save) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $counter
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500,
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_count()
    {
        try {
            $counts = Counter::all();
            if ($counts) {
                return response()->json([
                    'message' => 'success',
                    'status' => 200,
                    'data' => $counts
                ]);
            } else {
                return response()->json(
                    [
                        'message' => 'failed',
                        'status' => 500
                    ]
                );
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function index()
    {
        return $videos = HomeVideo::all();
        // dd($videos);
        return view('user.components.desktop', ['video' => $videos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required'
        ]);
        $app_url = env('APP_URL');
        // dd($app_url);
        $home_video = new HomeVideo();
        $home_video->name = $request->name;
        $home_video->meta_keyword = $request->meta_keyword;

        if ($request->file) {
            $fileName = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move(public_path('assets/home_video'), $fileName);

            $file_path = "assets/home_video/" . $fileName;
            $home_video->file = $file_path;
        }


        $save = $home_video->save();

        if ($save) {
            return response()->json(['success' => 'created']);
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
        return HomeVideo::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return HomeVideo::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->id);
        $request->validate([
            'name' => 'required',
        ]);
        $app_url = env('APP_URL');
        $home_video = HomeVideo::find($request->id);
        $home_video->meta_keyword = $request->meta_keyword;
        $home_video->name = $request->name;

        if ($request->file) {
            unlink($home_video->file);
            $fileName = time() . '.' . $request->file->getClientOriginalExtension();
            $request->file->move(public_path('assets/home_video'), $fileName);
            $file_path = "assets/home_video/" . $fileName;
            $home_video->file = $file_path;
        }


        $save = $home_video->save();

        if ($save) {
            return response()->json(['success' => 'updated']);
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
        $video = HomeVideo::find($id);
        $video->delete();
        return response()->json(['success' => 'You have successfully deleted file.']);
    }
}
