<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\KeyPoint;
use App\Models\Product;
use App\Models\SolvedProblem;
use App\Models\Technology;
use App\Models\UsingPurpose;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product_admin_view()
    {
        return view('admin.products');
    }
    public function index(Request $request)
    {
        // dd($request->all());
        try {
            $product = Product::with('keys', 'plans', 'features', 'using_purposes')->orderBy('id', 'desc')->paginate($request->per_page);
            if ($product) {
                return response()->json($product);
            } else {
                // return response()->json([
                //     'message' => 'not found',
                //     'status' => 404
                // ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_all(Request $request)
    {
        // dd($page_no);
        try {
            $product = Product::with('keys', 'plans', 'features', 'using_purposes')->get();
            // dd($product);
            if ($product) {
                return response()->json([
                    'message'    => 'success',
                    'status' => 200,
                    'data' => $product
                ], 200);
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function get_solved_problems()
    {
        return $product = SolvedProblem::all();
    }

    public function get_solved_problems_api()
    {
        $solved_problem = SolvedProblem::all();
        if ($solved_problem) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $solved_problem
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'status' => 404
            ], 404);
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
    public function store(Request $request)  //////// product store ////////
    {
        try {
            // dd($request->all());
            if ($request->product_logo) {

                $fileName = time() . '.' . $request->product_logo->getClientOriginalExtension();
                $request->product_logo->move(public_path('assets/img/product_logo'), $fileName);
                // dd($fileName);
                $product_logo = "assets/img/product_logo/" . $fileName;
            }

            if ($request->feature_image) {

                $fileName = time() . '.' . $request->feature_image->getClientOriginalExtension();
                $request->feature_image->move(public_path('assets/img/feature_image'), $fileName);
                // dd($fileName);
                $feature_image = "assets/img/feature_image/" . $fileName;
            }

            if ($request->cover_image) {

                $fileName = time() . '.' . $request->cover_image->getClientOriginalExtension();
                $request->cover_image->move(public_path('assets/img/cover_image'), $fileName);
                // dd($fileName);
                $cover_image = "assets/img/cover_image/" . $fileName;
            }
            $product = Product::create([
                'product_name' => isset($request->product_name) ? $request->product_name : '',
                'product_logo'
                => isset($product_logo) ? $product_logo : "",
                'title'
                => isset($request->title) ? $request->title : "",
                'description'
                => isset($request->description) ? $request->description : "",
                'cover_image'
                => isset($cover_image) ? $cover_image : "",
                'features_description'
                => isset($request->features_first_description) ? $request->features_first_description : "",
                'features_second_description'
                => isset($request->features_second_description) ? $request->features_second_description : "",
                'feature_image'
                => isset($feature_image) ? $feature_image : "",
                'total_users'
                => isset($request->total_users) ? $request->total_users : "",

                'key_points_header'
                => isset($request->key_points_header) ? $request->key_points_header : "",

                'using_purpose'
                => isset($request->using_purpose) ? $request->using_purpose : "",
            ]);

            if ($product) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => [
                        'product' => isset($product) ? $product : "",
                    ]
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }


        // KeyPoint
    }

    public function key_points_insert(Request $request)  ///key points save to database
    {
        // dd($request->all());
        try {
            $file_path = "";
            if ($request->key_points_image) {
                $fileName = time() . '.' . $request->key_points_image->getClientOriginalExtension();
                $request->key_points_image->move(public_path('assets/img/key_points_image'), $fileName);
                // dd($fileName);
                $file_path = "assets/img/key_points_image/" . $fileName;
            }
            // dd($file_path);
            $key_point = KeyPoint::create([
                'key_points_title' => $request->key_points_title,
                'key_points_text' => $request->key_points_text,
                'key_points_image' => $file_path,
                'product_id' => $request->product_id
            ]);
            // $request->solved_problem_title = "";
            // $request->solved_problem_image = "";
            if ($key_point) {


                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $key_point
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public function tech_insert(Request $request)  ///key points save to database
    // {
    //     // dd($request->tech);
    //     try {
    //         // dd($file_path);
    //         // foreach ($request->tech as $data) {
    //         $tech = Technology::create([
    //             'technology' => $request->tech,
    //             'product_id' => $request->product_id
    //         ]);
    //         // }

    //         if ($tech) {
    //             return response()->json([
    //                 'message' => 'success',
    //                 'status' => 201,
    //                 'data' => $tech
    //             ], 201);
    //         } else {
    //             return response()->json([
    //                 'message' => 'failed',
    //                 'status' => 500
    //             ], 500);
    //         }
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    public function using_purpose_save(Request $request)
    {  ///solved problem save to database
        // dd($request->all());
        try {
            // dd($file_path);
            $purpose = UsingPurpose::create([
                'using_purpose' => $request->text,
                'product_id' => $request->product_id
            ]);
            // $request->solved_problem_title = "";
            // $request->solved_problem_image = "";
            if ($purpose) {


                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $purpose
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function plan_insert(Request $request)
    {
        try {
            $problem = SolvedProblem::create([
                'plan' => $request->plan,
                'product_id' => $request->product_id,
                'price' => $request->price
            ]);
            // $request->solved_problem_title = "";
            // $request->solved_problem_image = "";
            if ($problem) {


                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $problem
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function features_save(Request $request)
    {
        try {
            $feature = Feature::create([
                'title' => $request->title,
                'product_id' => $request->product_id,
                'description' => $request->description
            ]);

            if ($feature) {
                return response()->json([
                    'message' => 'success',
                    'status' => 201,
                    'data' => $feature
                ]);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
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
    public function get_product_by_id($id)
    {
        $product = Product::where('id', $id)->with('keys', 'plans', 'features', 'using_purposes')->first();
        if ($product) {
            return response()->json([
                'message' => 'success',
                'status' => 200,
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'message' => 'not found',
                'status' => 404
            ], 404);
        }
    }

    public function edit($id)
    {
        // dd($id);
        $product = Product::where('id', $id)->with('keys', 'plans', 'features', 'using_purposes')->get();
        return response()->json([
            'data' => $product
        ]);
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
        $product = Product::find($id);
        if ($request->product_logo) {
            unlink(public_path($product->product_logo));
            $fileName = time() . '.' . $request->product_logo->getClientOriginalExtension();
            $request->product_logo->move(public_path('assets/img/product_logo'), $fileName);
            // dd($fileName);
            $product_logo = "assets/img/product_logo/" . $fileName;
        }

        if ($request->feature_image) {
            unlink(public_path($product->feature_image));
            $fileName = time() . '.' . $request->feature_image->getClientOriginalExtension();
            $request->feature_image->move(public_path('assets/img/feature_image'), $fileName);
            // dd($fileName);
            $feature_image = "assets/img/feature_image/" . $fileName;
        }

        if ($request->cover_image) {
            unlink(public_path($product->cover_image));
            $fileName = time() . '.' . $request->cover_image->getClientOriginalExtension();
            $request->cover_image->move(public_path('assets/img/cover_image'), $fileName);
            // dd($fileName);
            $cover_image = "assets/img/cover_image/" . $fileName;
        }
        $product->product_name = $request->product_name;
        $product->product_logo
            = isset($product_logo) ? $product_logo : $product->product_logo;
        $product->title
            = $request->title;
        $product->description
            = $request->description;
        $product->cover_image
            = isset($cover_image) ? $cover_image : $product->cover_image;
        $product->features_description
            = $request->features_first_description;
        $product->features_second_description
            = $request->features_second_description;
        $product->feature_image
            = isset($feature_image) ? $feature_image : $product->feature_image;
        $product->total_users
            = $request->total_users;

        $product->key_points_header
            = $request->key_points_header;

        $product->using_purpose
            = $request->using_purpose;
        $res = $product->save();

        if ($res) {
            return response()->json([
                'message' => 'Updated',
                'status' => 201,
                'data' => [
                    'product' => isset($res) ? $res : "",
                ]
            ], 201);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }

    public function update_plan(Request $request, $id)
    {
        // dd($request->plan);
        $plan = SolvedProblem::find($id);
        $plan->plan = $request->plan;
        $plan->price = $request->price;
        $update = $plan->save();
        if ($update) {
            return response()->json([
                'message' => 'Updated',
                'status' => 201,
                'data' => $update
            ], 201);
        } else {
            return response()->json([
                'message' => 'failed',
                'status' => 500
            ], 500);
        }
    }

    public function key_point_update(Request $request, $id)
    {
        // dd($request->all());
        $data = KeyPoint::find($id);
        if ($request->key_points_image) {
            unlink(public_path($data->key_points_image));
            $fileName = time() . '.' . $request->key_points_image->getClientOriginalExtension();
            $request->key_points_image->move(public_path('assets/img/key_points_image'), $fileName);
            // dd($fileName);
            $key_points_image = "assets/img/key_points_image/" . $fileName;
        }
        if ($data) {
            $data->key_points_title = $request->key_points_title;
            $data->key_points_text = $request->key_points_text;
            $data->key_points_image = isset($key_points_image) ? $key_points_image : $data->key_points_image;
            $update = $data->save();
            if ($update) {
                return response()->json([
                    'message' => "Updated",
                    'status' => 201
                ], 201);
            } else {
                return response()->json([
                    'message' => "Failed",
                    'status' => 500
                ], 500);
            }
        }
    }

    public function feature_update(Request $request, $id)
    {
        // dd($request->all());
        $data = Feature::find($id);
        if ($data) {
            $data->title = $request->title;
            $data->description = $request->description;
            $update = $data->save();
            if ($update) {
                return response()->json([
                    'message' => "Updated",
                    'status' => 201
                ], 201);
            } else {
                return response()->json([
                    'message' => "Failed",
                    'status' => 500
                ], 500);
            }
        }
    }

    public function add_data_to_existing(Request $request, $product_id, $flag)
    {
        if ($flag == 'plan') {
            $plan = new SolvedProblem();
            $plan->plan = $request->plan;
            $plan->price = $request->price;
            $plan->product_id = $product_id;
            $product = $plan->save();
            if ($product) {
                return response()->json([
                    'message' => "Updated",
                    'status' => 201,
                    'data' => $product
                ], 201);
            } else {
                return response()->json([
                    'message' => "Failed",
                    'status' => 500
                ], 500);
            }
        } else if ($flag == "key") {
            $fileName = time() . '.' . $request->key_points_image->getClientOriginalExtension();
            $request->key_points_image->move(public_path('assets/img/key_points_image'), $fileName);
            $key_points_image = "assets/img/key_points_image/" . $fileName;
            $key = new KeyPoint();
            $key->key_points_text = $request->key_points_text;
            $key->key_points_title = $request->key_points_title;
            $key->key_points_image = $key_points_image;
            $key->product_id = $product_id;
            $product = $key->save();
            if ($product) {
                return response()->json([
                    'message' => "Updated",
                    'status' => 201,
                    'data' => $product
                ], 201);
            } else {
                return response()->json([
                    'message' => "Failed",
                    'status' => 500
                ], 500);
            }
        } else if ($flag == 'feature') {
            $feature = new Feature();
            $feature->title = $request->title;
            $feature->description = $request->description;
            $feature->product_id = $product_id;
            $product = $feature->save();
            if ($product) {
                return response()->json([
                    'message' => "Updated",
                    'status' => 201,
                    'data' => $product
                ], 201);
            } else {
                return response()->json([
                    'message' => "Failed",
                    'status' => 500
                ], 500);
            }
        }
    }

    public function benefit_update(Request $request, $id)
    {
        // dd($request->all());
        $data = UsingPurpose::find($id);
        if ($data) {
            $data->using_purpose = $request->purpose;
            $update = $data->save();
            if ($update) {
                return response()->json([
                    'message' => "Updated",
                    'status' => 201
                ], 201);
            } else {
                return response()->json([
                    'message' => "Failed",
                    'status' => 500
                ], 500);
            }
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
        // dd("fgvfgfd");
        try {
            $product = Product::find($id);

            if ($product) {
                $delete = $product->delete();
                if ($delete) {
                    return response()->json([
                        'message' => 'deleted',
                        'status' => 201
                    ], 201);
                } else {
                    return response()->json([
                        'message' => 'failed',
                        'status' => 500
                    ], 500);
                }
            } else {
                return response()->json([
                    'message' => 'not found',
                    'status' => 404
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function destroy_prototype(Request $request)
    {
        // dd($request->all());
        try {
            if ($request->flag == "plan") {
                $product = SolvedProblem::find($request->id);

                if ($product) {
                    $delete = $product->delete();
                } else {
                    return response()->json([
                        'message' => 'not found',
                        'status' => 404
                    ]);
                }
            } else if ($request->flag == "key_point") {
                $product = KeyPoint::find($request->id);

                if ($product) {
                    $delete = $product->delete();
                } else {
                    return response()->json([
                        'message' => 'not found',
                        'status' => 404
                    ]);
                }
            } else if ($request->flag == "feature") {
                $product = Feature::find($request->id);

                if ($product) {
                    $delete = $product->delete();
                } else {
                    return response()->json([
                        'message' => 'not found',
                        'status' => 404
                    ]);
                }
            }

            if ($delete) {
                return response()->json([
                    'message' => 'Deleted',
                    'status' => 201
                ], 201);
            } else {
                return response()->json([
                    'message' => 'failed',
                    'status' => 500
                ], 500);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
