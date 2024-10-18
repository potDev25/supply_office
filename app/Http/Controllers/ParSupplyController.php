<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParSupplyRequest;
use App\Models\ClienPar;
use App\Models\ParSupply;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParSupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ClienPar $id)
    {
        $data = ParSupply::select('par_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'clien_pars.par_id', 'supplies.image_url', 'supplies.description', 'supplies.unit')
            ->join('users', 'users.id', '=', 'par_supplies.client_id')
            ->join('categories', 'categories.id', '=', 'par_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'par_supplies.supply_id')
            ->join('clien_pars', 'clien_pars.id', '=', 'clien_pars.par_id')
            ->where('par_supplies.par_id', $id->id)
            ->groupBy('par_supplies.id')
            ->get();
        $ids = [];
        foreach ($data as $key => $value) {
            $ids[] = $value->supply_id;
        }

        $supplies = Supply::whereNotIn('id', $ids)->
        where('qnty', '!=', 0)->get();

        return response(compact('data', 'supplies'));
    }

    public function client(User $id)
    {
        $data = ParSupply::select('par_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'clien_pars.par_id', 'supplies.image_url', 'supplies.description', 'supplies.unit')
            ->join('users', 'users.id', '=', 'par_supplies.client_id')
            ->join('categories', 'categories.id', '=', 'par_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'par_supplies.supply_id')
            ->join('clien_pars', 'clien_pars.id', '=', 'clien_pars.par_id')
            ->where('par_supplies.client_id', $id->id)
            ->groupBy('par_supplies.id')
            ->get();
        $ids = [];
        foreach ($data as $key => $value) {
            $ids[] = $value->supply_id;
        }

        $supplies = Supply::whereNotIn('id', $ids)->
        where('qnty', '!=', 0)->get();

        return response(compact('data', 'supplies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParSupplyRequest $request, ClienPar $par, Supply $id)
    {
        $payload = $request->validated();

        DB::transaction(function () use ($payload, $id, $par) {
            $id->qnty =  (int)$id->qnty - (int)$payload['qnty'];
            $id->save();

            $client = User::where('id', $par->client_id)->first();

            $total_price = (float)$id->price * (int)$payload['qnty'];
            ParSupply::create([
                'user_id' => auth()->user()->id,
                'supply_id' => $id->id,
                'category_id' => $id->category_id,
                'supply_name' => $id->supply_name,
                'total_price' => $total_price,
                'qnty' => (int)$payload['qnty'],
                'par_id' => $par->id,
                'client_id' => $par->client_id,
                'client_name' => $client->firstname . ' ' .$client->lastname,
                'status' => 'issued'
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
    public function update(Request $request, ParSupply $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        DB::transaction(function() use($id, $request){
            $id->status = $request->status;
            $id->save();
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
