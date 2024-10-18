<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReceivingRequest;
use App\Models\Receiving;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Receiving::orderBy('id', 'DESC')->paginate($request->limit);
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReceivingRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $payload['supplier'] = Supplier::where('id', $request->supplier)->first()->supplier_name;

        // Get the latest supplier, if it exists
        $latestSupplier = Receiving::latest('id')->first();

        // Check if a supplier exists, and if not, start from 1
        $latestId = $latestSupplier ? (int)$latestSupplier->id + 1 : 1;

        // Format the ID with leading zeros
        $formattedId = sprintf('%05d', $latestId);
        $payload['doc_id'] = $formattedId;

        DB::transaction(function () use($payload) {
            Receiving::create($payload);
        });

        $s = Supplier::orderBy('id', 'DESC')->get();

        return response($s[0]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Receiving $id)
    {
        return response($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receiving $id)
    {
        $payload = $request->validate([
            'date_arrived' => 'required',
            'supplier' => 'required',
        ]);

        DB::transaction(function () use($payload, $id) {
            $id->update($payload);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
