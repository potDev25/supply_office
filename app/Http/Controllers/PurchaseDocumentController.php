<?php

namespace App\Http\Controllers;

use App\Events\PurchaseDocumentEvent;
use App\Http\Requests\PurchaseRequestDocRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Requests\UploadPORequest;
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
        $data = PurchaseDocument::whereYear('created_at', Carbon::now()->year)
        ->where('pr_status', '!=', 'done')
        ->where('po_status', '!=', 'done')->get();
        return response($data);
    }

    public function purchaseRequest()
    {
        if(auth()->user()->role === 'general admin'){
            $data = PurchaseDocument::whereYear('created_at', Carbon::now()->year)->where('pr_status', 'awarded')
            ->where('po_status', '!=', 'done')
            ->where('purchase_order', '!=', null)
            ->get();
        }else{
            $data = PurchaseDocument::whereYear('created_at', Carbon::now()->year)->where('pr_status', 'awarded')->get();
        }
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
        event(new PurchaseDocumentEvent);
    }

    public function storePo(PurchaseDocument $document, UploadPORequest $request)
    {
        $payload = $request->validated();

        if($request->hasFile('purchase_order')){
            $payload['purchase_order'] = $request->file('purchase_order')->store('media', 'public');
        }
        
        $document->purchase_order = $payload['purchase_order'];
        $document->po_request_date =  Carbon::now();
        $document->po_status =  'for review';
        $document->save();

        event(new PurchaseDocumentEvent);
    }

    public function poCancel(PurchaseDocument $document)
    {
        $document->purchase_order = null;
        $document->po_request_date =  null;
        $document->po_status =  null;
        $document->save();

        event(new PurchaseDocumentEvent);
    }

    public function updateStatus(PurchaseDocument $document,UpdateStatusRequest $request){
        $data = $request->validated();
        $document->pr_status = $data['status'];
        // $document->deadline = $data['deadline'];
        $document->save();

        event(new PurchaseDocumentEvent);
    }

    public function updatePoStatus(PurchaseDocument $document,UpdateStatusRequest $request){
        $data = $request->validated();
        $document->po_status = $data['status'];
        if($data['status'] === 'done'){
            $document->pr_status = 'done';
        }
        // $document->deadline = $data['deadline'];
        $document->save();

        event(new PurchaseDocumentEvent);
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
