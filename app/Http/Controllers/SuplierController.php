<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuplierRequest;
use App\Models\Suplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $supliers = Suplier::get();

            return DataTables::of($supliers)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return
                        '<a class="btn btn-success text-white" data-target="update" href="'.route("suplier.show", $data->id).'" data-value="'.$data->id.'"><i class="fa fa-refresh"></i></a>
                        <button class="btn btn-danger  text-white " onclick="confirmDelete(this)" data-target="delete" data-value="'.$data->id.'"><i class="fa fa-trash"></i></button>';
                })
                ->addColumn('createdAt', function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
                })
                ->addColumn('updatedAt', function($data){
                    return Carbon::parse($data->updated_at)->format('d-m-Y H:i:s');
                })
                ->addColumn('status', function($data){
                    if($data->status === 'active') {
                        return '<div class="text-success p-2 bg-success-soft border-8px"> ACTIVE </div>';
                    } else  {
                        return '<div class="text-danger p-2 bg-danger-soft border-8px"> INACTIVE </div>';
                    }  
                })
                ->rawColumns([
                    'action',
                    'createAt',
                    'status'
                ])
                ->make(true);

        }
        return view('pages.supliers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.supliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuplierRequest $request)
    {
        $validate = $request->validated();

        Suplier::create($validate);

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
    public function show($id)
    {
        $suplier = Suplier::find($id);

        return view('pages.supliers.show', compact('suplier'));
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
    public function update(SuplierRequest $request, $id)
    {
        $validate = $request->validated();
        Suplier::find($id)
        ->update($validate);
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
            Suplier::destroy($id);
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
