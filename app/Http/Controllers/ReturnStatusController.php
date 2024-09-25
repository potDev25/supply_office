<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturStatusRequest;
use App\Models\ReturnStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = ReturnStatus::orderBy('return_status', 'ASC')->paginate($request->limit);

        return response($status);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReturStatusRequest $request)
    {
        $payload = $request->validated();

        DB::transaction(function () use ($payload){
            $status = ReturnStatus::create($payload);
            $status->name = $status->status .'_'.$status->id;
            $status->save();
        });
    }

    public function batch_delete(Request $request){
        $ids = $request->all();

        ReturnStatus::whereIn('id', $ids)->delete();

        return response(200);
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
    public function destroy(ReturnStatus $id)
    {
        $id->delete();
    }
}
