<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('role')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return
                        '<button class="btn btn-success mr-1" onclick="updateData(this)" 
                            data-id="' . $item->id . '" 
                            data-role="' . $item->role_id . '"
                            data-username="' . $item->username . '"
                            data-email="' . $item->email . '"
                            data-name="' . $item->name . '" >
                            <i class="fa fa-refresh"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteData(this)" data-id="' . $item->id . '">
                            <i class="fa fa-trash"></i>
                        </button>';
                })
                ->editColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
                })
                ->rawColumns([
                    'action',
                    'created_at'
                ])
                ->make(true);
        }
        $roles = Role::get();
        return view('pages.users.index', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        User::firstOrCreate([
            'username'  => $validated['username'],
        ], [
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'role_id'   => $validated['role_id'],
            'password'  => Hash::make($validated['username']),
        ]);

        return response()->json([
            'status'    => true,
            'message'   => 'Created User'
        ], 200);
    }

    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->update([
            'name'      => $validated['name'] ?? $user->name,
            'email'     => $validated['email'] ?? $user->email,
            'username'  => $validated['username'] ?? $user->username,
            'password'  => $validated['reset_password'] == true ? Hash::make($validated['username']) : $user->password
        ]);
        return response()->json([
            'status'    => true,
            'message'   => 'Success Mengubah Data'
        ], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status'    => true,
            'message'   => 'Success Menghapus Data'
        ], 200);
    }
}
