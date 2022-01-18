<?php

namespace App\Http\Controllers;

use App\Models\SellTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SellTransactionController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $purchases = SellTransaction::orderBy('updated_at', 'DESC')
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
                ->rawColumns([
                    'total',
                    'action',
                    'createdAt',
                ])
            ->make(true);
        }
        return view('pages.sell_transaction.index');
    }

    public function store(){

    }

    public function create(){
        return view('pages.sell_transaction.create');
    }
}
