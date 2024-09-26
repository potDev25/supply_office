<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnualRequest;
use App\Models\AnnualProcurementPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnualProcurementPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = AnnualProcurementPlan::orderBy('created_at', 'ASC')->paginate($request->limit);
        return response($data);
    }

    public function setFileName($file){
        return $file->getClientOriginalName();
    }

    public function getFormattedIdAttribute($id)
    {
        return sprintf('%05d', $id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnualRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;

        if($request->hasFile('document')){
            $payload['document'] = $request->file('document')->store('media', 'public');
            $payload['file_name'] = $this->setFileName($request->file('document'));
        }

        DB::transaction(function () use ($payload){
            $docs = AnnualProcurementPlan::create($payload);
            $docs->document_id = $this->getFormattedIdAttribute($docs->id);
            $docs->save();
        });

        return response(200);
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnualProcurementPlan $id)
    {
        return response($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnnualProcurementPlan $id)
    {
        $payload = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('document')){
            $request->validate([
               'document' => 'required|mimes:pdf'
            ]);

            $payload['document'] = $request->file('document')->store('media', 'public');
            $payload['file_name'] = $this->setFileName($request->file('document'));
        }

        DB::transaction(function () use ($payload, $id){
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
