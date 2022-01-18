<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
        }
        return view('pages.roles.index');
    }
}
