<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequestDocRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\PurchaseDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PurchaseDocument::whereYear('created_at', Carbon::now()->year)->where('pr_status', '!=', 'done')->get();
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseRequestDocRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $payload['pr_request_date'] = Carbon::now();

        if($request->hasFile('purchase_request')){
            $payload['purchase_request'] = $request->file('purchase_request')->store('media', 'public');
        }
        PurchaseDocument::create($payload);
    }

    public function updateStatus(PurchaseDocument $document,UpdateStatusRequest $request){
        $data = $request->validated();
        $document->pr_status = $data['status'];
        // $document->deadline = $data['deadline'];
        $document->save();
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
    public function destroy(PurchaseDocument $purchase)
    {
        $purchase->delete();
    }
}
