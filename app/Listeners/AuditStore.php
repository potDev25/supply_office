<?php

namespace App\Listeners;

use App\Events\AuditStoreEvent;
use App\Models\AuditTrails;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AuditStore
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
    public function handle(AuditStoreEvent $event): void
    {
        AuditTrails::create([
            'user_id' => auth()->user()->id,
            'action' => $event->data['action'],
            'type' => $event->data['type'],
        ]);
    }
}
