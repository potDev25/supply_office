<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Supplier::orderBy('supplier_name', 'ASC')->paginate($request->limit);
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;

        DB::transaction(function () use($payload) {
            Supplier::create($payload);
        });

        $data = Supplier::where('status', 'Active')->orderBy('supplier_name', 'ASC')->get();

        return response($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $id)
    {
        return response($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $id)
    {
        $payload = $request->validate([
            'supplier_name' => 'required|unique:suppliers,supplier_name,'.$id->id,
            'status' => 'required'
        ]);

        DB::transaction(function () use($payload, $id) {
            $id->update($payload);
        });

        $data = Supplier::where('status', 'Active')->orderBy('supplier_name', 'ASC')->get();

        return response($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
