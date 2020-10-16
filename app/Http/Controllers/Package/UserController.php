<?php

namespace App\Http\Controllers\Package;

use App\Models\Department;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::withRelations());
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->withDepartment($request->department_id);
        return response()->json($user);
    }

    public function show(User $user)
    {
        return response()->json($user::withRelations($user));
    }

    public function update(User $user, Request $request)
    {
       $user->update($request->all());

       return response()->json($user::withRelations($user));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json($user);
    }

}
