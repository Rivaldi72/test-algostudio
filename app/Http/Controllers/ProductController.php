<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $products = Product::with('category')->get();
            return DataTables::of($products)
                ->addIndexColumn()
                
                ->addColumn('action', function ($data) {
                        return
                        '<a class="btn btn-success text-white" data-target="update" href="'.route('product.show', $data->id).'" data-value="'.$data->id.'"><i class="fa fa-refresh"></i></a>
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
        return view('pages.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = ProductCategory::get();
        return view('pages.products.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validate = $request->validated();
        if($request->hasFile('image')){
            $file = $request->file('image');
            
            // Mendapatkan Nama File
            $nama_file = $file->getClientOriginalName();
            
            // Mendapatkan Extension File
            $extension = $file->getClientOriginalExtension();
            
            // Mendapatkan Ukuran File
            $ukuran_file = $file->getSize();
            
            // Proses Upload File
            $destinationPath = public_path('/upload/products');

            $image_name = time().'.'.$extension;

            $file->move($destinationPath,$image_name);
        }

        Product::create([
            'name'          => $validate['name'],
            'description'   => $validate['description'],
            'price'         => $validate['price'],
            'image'         => $image_name,
            'category_id'   => $validate['category_id'],
            'unit'          => $validate['unit'],
            'code'          => $validate['code']
        ]);

        return response()->json([
            'status'    => true
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $product = Product::find($id);
        if($request->ajax()){
            return response()->json($product);
        }
        return view('pages.products.show', compact('product'));
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
    public function update(ProductUpdateRequest $request, $id)
    {
        $validate = $request->validated();
        if($request->hasFile('image')){
            $file = $request->file('image');
            
            // Mendapatkan Nama File
            $nama_file = $file->getClientOriginalName();
            
            // Mendapatkan Extension File
            $extension = $file->getClientOriginalExtension();
            
            // Mendapatkan Ukuran File
            $ukuran_file = $file->getSize();
            
            // Proses Upload File
            $destinationPath = public_path('/upload/products');

            $image_name = time().'.'.$extension;

            $file->move($destinationPath,$image_name);
        }

        $product = Product::find($id);
        $product->update([
                'name'          => $validate['name'] ?? $product['name'],
                'description'   => $validate['description'] ?? $product['description'],
                'price'         => $validate['price'] ?? $product['price'],
                'image'         => $request->hasFile('image') ? $image_name : $product['image'],
                'category_id'   => $validate['category_id'] ?? $product['category_id'],
                'unit'          => $validate['unit'] ?? $product['unit'],
            ]);
        return response()->json([
            'status'    => true
        ], 200);
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
            Product::destroy($id);
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
