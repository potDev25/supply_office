<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RequisitionSlop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(auth()->user()->role == 'general admin'){
            $data = RequisitionSlop::select('requisition_slops.*', 'users.lastname', 'users.firstname')
            ->join('users', 'users.id', '=', 'requisition_slops.user_id')
            ->where('status', 'pending')->paginate($request->limit);
        }else{
            $data = RequisitionSlop::select('requisition_slops.*', 'users.lastname', 'users.firstname')
            ->join('users', 'users.id', '=', 'requisition_slops.user_id')
            ->where('status', 'pending')->where('user_id', auth()->user()->id)->paginate($request->limit);
        }

        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
       
        // Get the latest supplier, if it exists
        $latestSupplier = RequisitionSlop::latest('id')->first();

        // Check if a supplier exists, and if not, start from 1
        $latestId = $latestSupplier ? (int)$latestSupplier->id + 1 : 1;

        // Format the ID with leading zeros
        $formattedId = sprintf('%05d', $latestId);

        DB::transaction(function () use($formattedId) {
            RequisitionSlop::create([
                'ris_number' => $formattedId,
                'user_id' => auth()->user()->id
            ]);
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
