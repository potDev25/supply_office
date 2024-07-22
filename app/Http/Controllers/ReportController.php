<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportCollection;
use App\Models\Department;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::orderBy('department_name', 'ASC')->paginate($request->limit);

        if(auth()->user()->role === 'general admin'){
            $archive = new ReportCollection(Department::orderBy('department_name', 'ASC')->paginate($request->limit));
        }else{
            $archive = new ReportCollection(Department::where('id', auth()->user()->department_id)->orderBy('department_name', 'ASC')->get());
        }

        return response(compact('departments', 'archive'));
    }
}
