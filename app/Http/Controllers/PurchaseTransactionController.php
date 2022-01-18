<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\PurchaseTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class PurchaseTransactionController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $purchases = PurchaseTransaction::with('suplier')->orderBy('updated_at', 'DESC')
                ->get();
            return DataTables::of($purchases)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                    return
                        '<a class="btn btn-success" href="'.route("purchase.transaction.show", $data->id).'" ><i class="fa fa-book"></i></a>';
                })
                ->addColumn('total', function($data){
                    return number_format($data->total, 0, '', '.');
                })
                ->addColumn('createdAt', function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                })
                ->addColumn('updatedAt', function($data){
                    return Carbon::parse($data->updated_at)->format('d-m-Y H:i:s');
                })
                ->addColumn('status', function($data){
                    if($data->status === 'hold') {
                        return '<div class="text-primary p-2 bg-primary-soft border-8px"> Menunggu </div>';
                    } else if($data->status === 'cancel')  {
                        return '<div class="text-danger p-2 bg-danger-soft border-8px"> Dibatalkan </div>';
                    }  else {
                        return '<div class="text-success p-2 bg-success-soft border-8px"> Berhasil </div>';
                    }
                })
                ->rawColumns([
                    'total',
                    'action',
                    'createAt',
                    'status'
                ])
            ->make(true);
        }
        return view('pages.purchase_transactions.index');
    }

    public function show($id)
    {
        $purchase = PurchaseTransaction::with('products')->find($id);
        return view('pages.purchase_transactions.show', compact('purchase'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $product    = Product::find($request->input('product'));
            $purchase   = PurchaseTransaction::create([
                'invoice'       => time().'/BUR/PUR/'.Carbon::now()->format('m/Y'),
                'suplier_id'    => $request->input('suplier'),
                'total'         => (int) $product['price'] * $request->input('unit')
            ]);
            
            ProductPurchase::create([
                'purchase_id'   => $purchase->id,
                'product_id'    => $request->input('product'),
                'quantity'      => $request->input('unit'),
            ]);

            DB::commit();
            return response()->json([
                'status'    => true
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'    => false
            ]);
            //throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $status = $request->input('status');

        $action = $request->input('action');

        $purchase = PurchaseTransaction::find($id);

        switch($action){
            case 'approve' : 
                DB::beginTransaction();
                $purchase->update([
                    'status'    => 'success'
                ]);
                foreach ($purchase->products as $product ) {
                    
                    Product::where('id', $product->id)
                    ->update([
                        'unit'  => (int) $product->unit + $product->quantity
                    ]);
                }

                DB::commit();
                return response()->json(['status' => true], 200);
                break;
        }

    }
}
