<?php

namespace App\Http\Controllers;

use App\Events\AuditStoreEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\clientParRequest;
use App\Models\ClienPar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientParController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('role', 'admin')->orderBy('lastname', 'ASC')->get();


        if (auth()->user()->role === 'general admin') {
            $pars = ClienPar::select('clien_pars.*', 'users.lastname', 'users.firstname')
                ->join('users', 'clien_pars.client_id', '=', 'users.id')
                ->paginate($request->limit);
        } else {
            $pars = ClienPar::select('clien_pars.*', 'users.lastname', 'users.firstname')
                ->join('users', 'clien_pars.client_id', '=', 'users.id')
                ->where('clien_pars.user_id', auth()->user()->id)
                ->paginate($request->limit);
        }

        return response(compact('users', 'pars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(clientParRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;

        $latestSupplier = ClienPar::latest('id')->first();

        // Check if a supplier exists, and if not, start from 1
        $latestId = $latestSupplier ? (int)$latestSupplier->id + 1 : 1;

        // Format the ID with leading zeros
        $formattedId = sprintf('%05d', $latestId);
        $payload['par_id'] = $formattedId;

        DB::transaction(function () use ($payload) {
            ClienPar::create($payload);

            $data = [
                'action' => 'Create PAR (' . $payload['par_id'] . ')',
                'type' => 'PAR'
            ];
            event(new AuditStoreEvent($data));
        });
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
