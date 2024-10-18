<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RisSuppliesRequest;
use App\Http\Requests\StockRequest;
use App\Models\ReceivedSupply;
use App\Models\Receiving;
use App\Models\RequisitionSlop;
use App\Models\RisSupplies;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Receiving $receiving)
    {
        $data = ReceivedSupply::select('received_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'receivings.doc_id', 'receivings.supplier', 'supplies.image_url', 'supplies.description', 'supplies.unit')
            ->join('users', 'users.id', '=', 'received_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'received_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'received_supplies.supply_id')
            ->join('receivings', 'receivings.id', '=', 'received_supplies.receive_id')
            ->where('received_supplies.receive_id', $receiving->id)
            ->get();
        $ids = [];
        foreach ($data as $key => $value) {
            $ids[] = $value->supply_id;
        }

        $supplies = Supply::whereNotIn('id', $ids)->get();

        return response(compact('data', 'supplies'));
    }

    public function store(Supply $id, StockRequest $request, Receiving $receive)
    {
        $payload = $request->validated();

        DB::transaction(function () use ($payload, $id, $receive) {
            $id->qnty =  (int)$id->qnty + (int)$payload['qnty'];
            $id->price = $payload['price'];
            $id->save();

            $total_price = (float)$payload['price'] * (int)$payload['qnty'];
            ReceivedSupply::create([
                'user_id' => auth()->user()->id,
                'supply_id' => $id->id,
                'category_id' => $id->category_id,
                'supply_name' => $id->supply_name,
                'total_price' => $total_price,
                'qnty' => (int)$payload['qnty'],
                'price' => $payload['price'],
                'receive_id' => $receive->id
            ]);
        });
    }

    public function requests(RequisitionSlop $requesition)
    {
        $data = RisSupplies::select('ris_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'requisition_slops.ris_number', 'supplies.image_url', 'supplies.description', 'supplies.unit')
            ->join('users', 'users.id', '=', 'ris_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'ris_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'ris_supplies.supply_id')
            ->join('requisition_slops', 'requisition_slops.id', '=', 'ris_supplies.ris_id')
            ->where('ris_supplies.ris_id', $requesition->id)
            ->get();
        $ids = [];
        foreach ($data as $key => $value) {
            $ids[] = $value->supply_id;
        }

        $supplies = Supply::whereNotIn('id', $ids)->get();

        return response(compact('data', 'supplies', 'requesition', 'requesition'));
    }

    public function requestStore(Supply $id, RisSuppliesRequest $request, RequisitionSlop $receive)
    {
        $payload = $request->validated();

        DB::transaction(function () use ($payload, $id, $receive) {
            $price = $id->price ?? 0;
            $total_price = $price * (int)$payload['qnty'];
            RisSupplies::create([
                'user_id' => auth()->user()->id,
                'supply_id' => $id->id,
                'category_id' => $id->category_id,
                'supply_name' => $id->supply_name,
                'total_price' => $total_price,
                'qnty' => (int)$payload['qnty'],
                'price' => $id->price,
                'ris_id' => $receive->id
            ]);
        });
    }

    public function submitForm(RequisitionSlop $requesition) {
        $requesition->submit = 1;
        $requesition->save();
    }
}
