<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $numbers = [];

        if(auth()->user()->role === 'general admin'){
            if(!isset($request->status)){
                $data = Document::select('documents.*', 'documents.id as document_id', 'documents.status as document_status', 'users.id as user_id', 'users.*', 'departments.*', 'applicants.*', 'applicants.id as applicant_id', 'media.*')
                ->join('users', 'documents.user_id', '=', 'users.id')
                ->join('applicants', 'users.id', '=', 'applicants.user_id')
                ->join('media', 'applicants.id', '=', 'media.applicant_id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->where('documents.status', '!=', 'done')
                ->where('documents.status', '!=', 'return')
                ->orderBy('documents.created_at', 'DESC')->get();
            }else{
                $data = Document::select('documents.*', 'documents.id as document_id', 'documents.status as document_status', 'users.id as user_id', 'users.*', 'departments.*', 'applicants.*', 'applicants.id as applicant_id', 'media.*')
                ->join('users', 'documents.user_id', '=', 'users.id')
                ->join('applicants', 'users.id', '=', 'applicants.user_id')
                ->join('media', 'applicants.id', '=', 'media.applicant_id')
                ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
                ->where('documents.status', $request->status)
                ->orderBy('documents.created_at', 'DESC')->get();
            }
        }else{
            $data = Document::select('documents.*', 'documents.id as document_id', 'documents.status as document_status', 'users.id as user_id', 'users.*', 'departments.*', 'applicants.*', 'applicants.id as applicant_id', 'media.*')
            ->join('users', 'documents.user_id', '=', 'users.id')
            ->join('applicants', 'users.id', '=', 'applicants.user_id')
            ->join('media', 'applicants.id', '=', 'media.applicant_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->where('documents.status', '!=', 'done')
            ->where('documents.user_id', auth()->user()->id)
            ->orderBy('documents.created_at', 'DESC')->get();
        }

        $numbers = [
            'for_review' => Document::where('status', 'for review')->count(),
            'return' => Document::where('status', 'return')->count(),
            'president_office' => Document::where('status', 'president office')->count(),
            'accounting_office' => Document::where('status', 'accounting office')->count(),
            'office_supply' => Document::where('status', 'supply office')->count(),
        ];

        return response(compact('data', 'numbers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        if($request->hasFile('document')){
            $data['document'] = $request->file('document')->store('media', 'public');
        }

        Document::create($data);
    }

    public function cancel(Document $document){
        $document = $document->delete();
    }

    public function changeStatus(Document $document, UpdateStatusRequest $request){
        $data = $request->validated();
        $document->status = $data['status'];
        $document->deadline = $data['deadline'];
        $document->save();
    }

    public function returnStatus(Document $document, Request $request){
        $data = $request->validate([
            'message' => 'required',
            'status' => 'required'
        ]);
        $document->status = $data['status'];
        $document->message = $data['message'];
        $document->save();
    }

    public function updateFile(Document $document, Request $request){
        $data = $request->validate([
            'document' => 'required|mimes:pdf',
            'status' => 'required'
        ]);

        if($request->hasFile('document')){
            $data['document'] = $request->file('document')->store('media', 'public');
        }

        $document->status = $data['status'];
        $document->document = $data['document'];
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
    public function destroy(string $id)
    {
        //
    }
}
