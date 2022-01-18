<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Suplier;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function productAll(Request $request)
    {
        $products = Product::where('name', 'like', '%'.$request->input('term')['term'].'%')
                    ->get();
        return response()->json($products, 200);
    }

    public function productById($id)
    {
        $product = Product::find($id);
        return response()->json($product, 200);
    }

    public function suplierAll(Request $request)
    {   
        if($request->has('term')){
            $supliers = Suplier::where('name', 'like', '%'.$request->input('term')['term'].'%')
            ->get();
        }else {
            $supliers = Suplier::get();
        }
        return response()->json($supliers, 200);
    }

    public function suplierById($id)
    {
        $suplier = Suplier::find($id);
        return response()->json($suplier, 200);
    }

}
