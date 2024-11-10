<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AuditTrails;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AuditTrails::query();

        $query->when($request->filled('start_date'), function($q) use ($request) {
            if ($request->start_date === $request->end_date) {
                // If the start_date and end_date are the same, filter by that specific date
                $q->whereDate('audit_trails.created_at', $request->start_date);
            } else {
                // Otherwise, use whereBetween to filter by the date range
                $q->whereBetween('audit_trails.created_at', [$request->start_date, $request->end_date]);
            }
        });
        

        $data = $query->select('audit_trails.*', 'users.lastname', 'users.firstname', 'users.role')
        ->join('users', 'audit_trails.user_id', '=', 'users.id')
        ->where('audit_trails.type', $request->type)
        ->orderBy('created_at', 'DESC')
        ->paginate($request->limit);
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
