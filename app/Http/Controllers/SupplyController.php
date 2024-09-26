<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplyRequest;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $supplies = Supply::select('supplies.*', 'categories.name')->join('categories', 'supplies.category_id', '=', 'categories.id')
            ->orderBy('supplies.created_at', 'DESC')->paginate($request->limit);

        return response($supplies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplyRequest $request)
    {
        $payload = $request->validated();

        if($request->hasFile('image_url')){
            $payload['image_url'] = $request->file('image_url')->store('media', 'public');
        }

        DB::transaction(function () use ($payload){
            Supply::create($payload);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $id)
    {
        return response($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supply $id)
    {
        $payload = $request->validate([
            'supply_name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'unit' => 'required',
        ]);

        if($request->hasFile('image_url')){
            $request->validate([
                'image_url' => 'required|mimes:png,jpg',
            ]);
            $payload['image_url'] = $request->file('image_url')->store('media', 'public');
        }

        DB::transaction(function () use($payload, $id){
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
