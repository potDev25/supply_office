<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentCollection;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::orderBy('department_name', 'ASC')->paginate($request->limit);

        if(auth()->user()->role === 'general admin'){
            $archive = new DepartmentCollection(Department::orderBy('department_name', 'ASC')->paginate($request->limit));
        }else{
            $archive = new DepartmentCollection(Department::where('id', auth()->user()->department_id)->orderBy('department_name', 'ASC')->get());
        }

        return response(compact('departments', 'archive'));
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
    public function show(Department $department)
    {
        return response($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $payload = $request->validate([
            'department_name' => 'required',
            'department_type' => 'required',
        ]);

        if($request->hasFile('logo')){
            $request->validate([
               'logo' => 'required|mimes:png,jpg'
            ]);

            $payload['logo'] = $request->file('logo')->store('media', 'public');
        }

        DB::transaction(function () use ($payload, $department){
            $department->update($payload);
        });
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
