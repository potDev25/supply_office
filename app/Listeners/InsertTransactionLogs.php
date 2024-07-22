<?php

namespace App\Listeners;

use App\Events\TransactionChanged;
use App\Models\TransactionLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InsertTransactionLogs
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionChanged $event): void
    {
        TransactionLog::create([
            'document_id' => $event->document->id,
            'deadline' => $event->document->deadline,
            'date_submitted' => $event->document->created_at,
            'status' => $event->document->status,
        ]);
    }
}
