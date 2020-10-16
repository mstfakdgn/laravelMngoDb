<?php

namespace App\Http\Controllers\Package;

use App\Models\User;
use App\Models\Writing;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class WritingController extends Controller
{
    public function index()
    {
        return response()->json(Writing::withRelationships());
    }

    public function store(Request $request)
    {
        $writing = Writing::create($request->all());

        $writing->users()->attach($request->user_ids);
        return response()->json(Writing::withRelationships($writing));
    }

    public function show(Writing $writing)
    {
        return response()->json(Writing::withRelationships($writing));
    }

    public function update(Writing $writing, Request $request)
    {
        $writing->update($request->all());

        return response()->json(Writing::withRelationships($writing));
    }

    public function destroy(Writing $writing)
    {
        $writing->delete();

        return response()->json($writing);
    }

    public function detach(Writing $writing, User $user)
    {
        $writing->users()->detach($user);
        
        return response()->json(Writing::withRelationships($writing));
    }

    public function getUsers(Writing $writing)
    {
        $users = [];
        foreach ($writing->user_ids as $userId) {
            $user = User::find($userId);
            array_push($users, $user);
        }

        return response()->json($users);
    }
}
