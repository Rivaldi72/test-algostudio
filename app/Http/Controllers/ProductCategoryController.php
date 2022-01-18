<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            if($request->has('term')){
                $category = ProductCategory::where('name', 'like', '%'.$request->input('term')['term'].'%')->get();
            } else {
                $category = ProductCategory::get();
            }
            return DataTables::of($category)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return
                        '<button onclick="openModal(this)" class="btn btn-success text-white" data-target="update" data-value="'.$data->id.'"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-danger  text-white " onclick="confirmDelete(this)" data-target="delete" data-value="'.$data->id.'"><i class="fa fa-trash"></i></button>';
                })
                ->addColumn('createdAt', function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                })
                ->addColumn('updatedAt', function($data){
                    return Carbon::parse($data->updated_at)->format('d-m-Y H:i:s');
                })
                ->rawColumns([
                    'action',
                    'createAt'
                ])
                ->make(true);
        }
        return view('pages.product_categories.index');
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
    public function store(ProductCategoryRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            ProductCategory::create([
                'name' => $validated['name']
            ]);
            DB::commit();

            return response()->json([
                'status' => true
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
            ], 200);
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
        $category = ProductCategory::find($id);

        return response()->json([
            'status'    => true,
            'data'      => $category
        ], 200);
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
    public function update(ProductCategoryRequest $request, $id)
    {
        $validated = $request->validated();
        $category = ProductCategory::find($id);
        DB::beginTransaction();
        try {
            $category->update([
                'name' => $validated['name']
            ]);
            DB::commit();

            return response()->json([
                'status' => true
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
            ], 200);
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
            ProductCategory::destroy($id);
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => false
            ], 200);
        }
        
    }
}
