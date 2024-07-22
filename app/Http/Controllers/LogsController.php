<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\TransactionLog;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(Document $document){
        $data = TransactionLog::where('document_id', $document->id)->get();
        return response($data);
    }
}
