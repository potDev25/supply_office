<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParSupplyRequest;
use App\Models\ClienPar;
use App\Models\ParSupply;
use App\Models\ReceivedSupply;
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

        $supplies = Supply::whereNotIn('id', $ids)->where('qnty', '!=', 0)->get();

        return response(compact('data', 'supplies'));
    }

    public function reports(Request $request)
    {
        $query = ParSupply::query();
        $total_query = ParSupply::query();

        $query->when($request->filled('month'), function ($q) use ($request) {
            $q->whereMonth('par_supplies.created_at', $request->month)
                ->whereYear('par_supplies.created_at', $request->year);
        });

        $query->when($request->filled('client'), function ($q) use ($request) {
            $q->where('par_supplies.client_id', $request->client);
        });

        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('par_supplies.status', $request->status);
        });

        $total_query->when($request->filled('month'), function ($q) use ($request) {
            $q->whereMonth('par_supplies.created_at', $request->month)
                ->whereYear('par_supplies.created_at', $request->year);
        });

        $data = $query->select(
            'par_supplies.*',
            'users.lastname',
            'users.firstname',
            'categories.name',
            'clien_pars.par_id as parID',
            'supplies.image_url',
            'supplies.description',
            'supplies.unit',
            DB::raw('par_supplies.qnty * par_supplies.total_price as total_value')
        )
            ->join('users', 'users.id', '=', 'par_supplies.client_id')
            ->join('categories', 'categories.id', '=', 'par_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'par_supplies.supply_id')
            ->join('clien_pars', 'clien_pars.id', '=', 'clien_pars.par_id')
            ->groupBy('par_supplies.id')
            ->paginate($request->limit);

        $totalValueSum = $total_query->select(
            DB::raw('SUM(par_supplies.qnty * par_supplies.total_price) as total_value_sum')
        )
            ->join('users', 'users.id', '=', 'par_supplies.client_id')
            ->join('categories', 'categories.id', '=', 'par_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'par_supplies.supply_id')
            ->join('clien_pars', 'clien_pars.id', '=', 'clien_pars.par_id')
            ->first();

        $clients = ParSupply::select(
            'users.id as user_id',
            DB::raw("CONCAT(users.firstname, ' ', users.lastname) as client_name")
        )
            ->join('users', 'users.id', '=', 'par_supplies.client_id')
            ->whereMonth('par_supplies.created_at', $request->month)
            ->whereYear('par_supplies.created_at', $request->year)
            ->distinct()
            ->get();

        $total_query_supply = ParSupply::whereMonth('par_supplies.created_at', $request->month)
            ->whereYear('par_supplies.created_at', $request->year)
            ->count();

        $status = [
            'issued' => ParSupply::whereMonth('par_supplies.created_at', $request->month)->whereYear('par_supplies.created_at', $request->year)->where('status', 'issued')->count(),
            'return' => ParSupply::whereMonth('par_supplies.created_at', $request->month)->whereYear('par_supplies.created_at', $request->year)->where('status', 'return')->count(),
            'unserviceable' => ParSupply::whereMonth('par_supplies.created_at', $request->month)->whereYear('par_supplies.created_at', $request->year)->where('status', 'unserviceable')->count(),
        ];

        $ids = [];
        foreach ($data as $key => $value) {
            $ids[] = $value->supply_id;
        }

        $stocks_data = ReceivedSupply::GetTotalPriceByStatusAndMonthYear($request->month, $request->year);

        $supplies = Supply::whereNotIn('id', $ids)->where('qnty', '!=', 0)->get();

        return response(compact('data', 'supplies', 'totalValueSum', 'clients', 'status', 'total_query_supply', 'stocks_data'));
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

        $supplies = Supply::whereNotIn('id', $ids)->where('qnty', '!=', 0)->get();

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
                'client_name' => $client->firstname . ' ' . $client->lastname,
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

        DB::transaction(function () use ($id, $request) {
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
