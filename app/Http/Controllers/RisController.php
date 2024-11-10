<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\RequisitionSlop;
use App\Models\RisSupplies;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $department = null;
        if (auth()->user()->role == 'general admin') {
            if ($request->filled('department_id')) {
                $data = RequisitionSlop::select('requisition_slops.*', 'users.lastname', 'users.firstname')
                    ->join('users', 'users.id', '=', 'requisition_slops.user_id')
                    ->where('status', 'issued')
                    ->where('users.department_id', $request->department_id)
                    ->orderBy('created_at', 'DESC')
                    ->paginate($request->limit);

                $department = Department::where('id', $request->department_id)->first();
            }else{
                $data = RequisitionSlop::select('requisition_slops.*', 'users.lastname', 'users.firstname')
                    ->join('users', 'users.id', '=', 'requisition_slops.user_id')
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($request->limit);
            }
        } else {
            $query = RequisitionSlop::query();

            $query->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            });

            $data = $query->select('requisition_slops.*', 'users.lastname', 'users.firstname')
                ->join('users', 'users.id', '=', 'requisition_slops.user_id')
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'DESC')
                ->paginate($request->limit);
        }

        return response(compact('department', 'data'));
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

        DB::transaction(function () use ($formattedId) {
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

    public function supply(RisSupplies $id)
    {
        $data = RisSupplies::select('ris_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'requisition_slops.ris_number', 'supplies.image_url', 'supplies.description', 'supplies.unit', 'supplies.qnty as available_supply')
            ->join('users', 'users.id', '=', 'ris_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'ris_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'ris_supplies.supply_id')
            ->join('requisition_slops', 'requisition_slops.id', '=', 'ris_supplies.ris_id')
            ->where('ris_supplies.id', $id->id)
            ->first();
        return response($data);
    }

    public function supplyUpdate(RisSupplies $id, Request $request)
    {
        $payload = $request->validate([
            'availbale' => 'required',
            'qnty' => 'required_if:available,1'
        ]);

        DB::transaction(function () use ($payload, $id) {
            $price = $payload['availbale'] == 1 ? $payload['qnty'] : 0;
            $payload['issued_total_price'] = (float)$price * $id->price;
            $payload['issued_qnty'] = $payload['availbale'] == 1 ? $payload['qnty'] : 0;
            $payload['status'] = $payload['availbale'] == 1 ? 'issued' : 'not available';

            if ($payload['availbale'] == 2) {
                $payload['qnty'] = $id->qnty;
            }

            $id->update($payload);

            if ($payload['availbale'] == 1) {
                $supply = Supply::where('id', $id->supply_id)->first();
                $supply->qnty = $supply->qnty -  $payload['issued_qnty'];
                $supply->save();
            }
        });
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
