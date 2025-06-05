<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\role_user;
use App\Models\roles;
use App\Models\UserRole;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;

class ManageUser extends Controller
{

    public function index(Request $request)
    {
        $roleFilter = $request->input('roleFilter');

        $query = User::join('user_roles', 'user_roles.user_id', '=', 'users.id')
        ->select('users.*');
        if ($roleFilter !== 'all') {
            $query->where('user_roles.role_id', $roleFilter); 
        }


        $users = $query->distinct()->paginate(10);

        return view('Admin.home', compact('users', 'roleFilter'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        return view('Admin.user_edit', [
            'user' => User::where('id', $id)->first()
        ]);
    }

    public function update(Request $request, string $id)
    {
        User::join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->where('id', $id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
        return redirect()->route('admin.index')
            ->with('success', 'User Information Updated.');
    }

    public function destroy(string $id)
    {
        User::destroy($id);
        return redirect()->route('admin.index')->with('success', 'User has been deleted');
    }

    //Roles Fuctions
    public function createRole(string $id)
    {
        $user = $id;
        $users = User::all();
        $all_roles = roles::all();
        return view('Admin.user_roles_create', compact('all_roles', 'users', 'user'));
    }
    public function storeRole(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'role_id' => ' required',
        ]);
        UserRole::create($validatedData);
        return redirect()->route('admin.index')->with('success', 'New Role has been assigned');
    }

    public function editRoles(string $id)
    {
        $all_roles = roles::all();

        $roles = roles::leftJoin('user_roles', 'roles.role_id', '=', 'user_roles.role_id')
            ->get(['roles.*', 'user_roles.*']);

        $user_roles = User::join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->join('roles', 'roles.role_id', '=', 'user_roles.role_id')
            ->where('users.id', '=', $id)
            ->get(['users.*', 'user_roles.*', 'roles.*']);

        $user = User::join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->join('roles', 'roles.role_id', '=', 'user_roles.role_id')
            ->where('users.id', '=', '$id')
            ->get(['users.*', 'user_roles.*', 'roles.*']);

        return view('Admin.user_roles_edit', [
            'user' => User::where('id', $id)->first()
        ], compact('user', 'roles', 'user_roles', 'all_roles'));
    }

    public function updateRoles(Request $request, string $id)
    {
        $roleUser = UserRole::findOrFail($id);
        $request->validate([
            'role_id' => 'required|integer',
        ]);
        $roleUser->update([
            'role_id' => $request->input('role_id'),
        ]);
        return redirect()->route('admin.index')
            ->with('success', 'User Information Updated.');
    }
    public function destroyRoles(string $ur_id)
    {
        UserRole::destroy($ur_id);
        return redirect()->route('admin.index')->with('success', 'User has been deleted');
    }

    public function fileUserImport(Request $request)
    {
        $filePath = $request->file('file')->store('temp');
        Excel::import(new UsersImport, $filePath);
        return back();
    }

    public function fileUserExport()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
        return redirect()->route('admin.index');
    }
}
