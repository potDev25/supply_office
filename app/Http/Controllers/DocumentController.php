<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role === 'general admin'){
            $data = Document::select('documents.*', 'documents.status as document_status', 'users.id as user_id', 'users.*', 'departments.*', 'applicants.*', 'applicants.id as applicant_id', 'media.*')
            ->join('users', 'documents.user_id', '=', 'users.id')
            ->join('applicants', 'users.id', '=', 'applicants.user_id')
            ->join('media', 'applicants.id', '=', 'media.applicant_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->where('status', '!=', 'done')
            ->orderBy('documents.created_at', 'DESC')->get();
        }else{
            $data = Document::select('documents.*', 'documents.status as document_status', 'users.id as user_id', 'users.*', 'departments.*', 'applicants.*', 'applicants.id as applicant_id', 'media.*')
            ->join('users', 'documents.user_id', '=', 'users.id')
            ->join('applicants', 'users.id', '=', 'applicants.user_id')
            ->join('media', 'applicants.id', '=', 'media.applicant_id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->where('status', '!=', 'done')
            ->where('documents.user_id', auth()->user()->id)
            ->orderBy('documents.created_at', 'DESC')->get();
        }

        return response($data);
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
