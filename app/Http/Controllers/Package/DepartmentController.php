<?php

namespace App\Http\Controllers\Package;

use App\Models\Department;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return response()->json(Department::all());
    }

    public function store(Request $request)
    {
        return response()->json(Department::create($request->all()));
    }

    public function show(Department $department)
    {
        return response()->json(Department::find($department));
    }

    public function update(Department $department, Request $request)
    {
        $department->update($request->all());

        return response()->json($department);
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json($department);
    }
}
