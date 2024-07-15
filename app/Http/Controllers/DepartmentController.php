<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::orderBy('department_name', 'ASC')->paginate($request->limit);

        return response($departments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        $data = $request->validated();

        $string = $data['department_name'];
        $data['name'] = str_replace(' ', '_', $string);

        if($request->hasFile('logo')){
            $data['logo'] = $request->file('logo')->store('media', 'public');
        }

        Department::create($data);

        $departments = Department::orderBy('department_name', 'ASC')->get();

        return response($departments);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response(200);
    }

    public function batch_delete(Request $request){
        $ids = $request->all();

        Department::whereIn('id', $ids)->delete();

        return response(200);
    }
}
