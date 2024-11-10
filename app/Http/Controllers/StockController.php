<?php

namespace App\Http\Controllers;

use App\Events\AuditStoreEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RisSuppliesRequest;
use App\Http\Requests\StockRequest;
use App\Models\Department;
use App\Models\HeadTeacher;
use App\Models\ReceivedSupply;
use App\Models\Receiving;
use App\Models\RequisitionSlop;
use App\Models\RisSupplies;
use App\Models\Supply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
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

    public function stockin_reports(Request $request)
    {
        $data = ReceivedSupply::select('received_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'receivings.doc_id', 'receivings.supplier', 'supplies.image_url', 'supplies.description', 'supplies.unit')
            ->join('users', 'users.id', '=', 'received_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'received_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'received_supplies.supply_id')
            ->join('receivings', 'receivings.id', '=', 'received_supplies.receive_id')
            ->whereMonth('received_supplies.created_at', $request->month)
            ->whereYear('received_supplies.created_at', $request->year)
            ->paginate($request->limit);

        $total_costs = ReceivedSupply::whereMonth('received_supplies.created_at', $request->month)
            ->whereYear('received_supplies.created_at', $request->year)
            ->sum('total_price');
        $formatted_total_costs = number_format($total_costs, 2, '.', ',');

        $distinctCategoryCount = ReceivedSupply::whereMonth('received_supplies.created_at', $request->month)
            ->whereYear('received_supplies.created_at', $request->year)
            ->distinct('category_id')
            ->count('category_id');

        $total_supplies = ReceivedSupply::whereMonth('received_supplies.created_at', $request->month)
            ->whereYear('received_supplies.created_at', $request->year)->count();

        $total_price_per_category = ReceivedSupply::select(
            'categories.name as category_name',
            'received_supplies.category_id',
            DB::raw('SUM(received_supplies.total_price) as total_price')
        )
            ->join('categories', 'categories.id', '=', 'received_supplies.category_id')
            ->whereMonth('received_supplies.created_at', $request->month)
            ->whereYear('received_supplies.created_at', $request->year)
            ->groupBy('received_supplies.category_id', 'categories.name')  // Grouping by category_id and category name
            ->get();

        $stocks_analysis = ReceivedSupply::GetSuppliesByMonthYear($request->month, $request->year);

        return response(compact('data', 'formatted_total_costs', 'total_supplies', 'distinctCategoryCount', 'total_price_per_category', 'stocks_analysis'));
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
        $data = RisSupplies::select('ris_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'requisition_slops.ris_number', 'supplies.image_url', 'supplies.description', 'supplies.unit', 'supplies.qnty as available_supply')
            ->join('users', 'users.id', '=', 'ris_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'ris_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'ris_supplies.supply_id')
            ->join('requisition_slops', 'requisition_slops.id', '=', 'ris_supplies.ris_id')
            ->where('ris_supplies.ris_id', $requesition->id)
            ->get();
        $ids = [];
        $total_price = 0;
        foreach ($data as $key => $value) {
            $ids[] = $value->supply_id;
            $total_price += (float)$value->issued_total_price ?? 0;
        }

        $supplies = Supply::whereNotIn('id', $ids)
            ->where('qnty', '!=', 0)
            ->get();
        $ris = RequisitionSlop::select('users.lastname', 'users.firstname', 'requisition_slops.*', 'users.position')
            ->join('users', 'users.id', '=', 'requisition_slops.user_id')
            ->where('requisition_slops.id', $requesition->id)
            ->first();

        $approve = [];

        $signature = HeadTeacher::where('user_id', $requesition->approved_by)->first();
        $requistor = HeadTeacher::where('user_id', $requesition->user_id)->first();

        if ($ris->approved_by) {
            $approve = User::where('id', $ris->approved_by)->first();
        }

        return response(compact('data', 'supplies', 'requesition', 'requesition', 'ris', 'approve', 'total_price', 'signature', 'requistor'));
    }

    public function reports(Department $department, Request $request)
    {
        $month = $request->query('month', now()->month); // Default to current month if not provided
        $year = $request->query('year', now()->year); // Default to current year if not provided

        $data = RisSupplies::select('ris_supplies.*', 'users.lastname', 'users.firstname', 'categories.name', 'requisition_slops.ris_number', 'supplies.image_url', 'supplies.description', 'supplies.unit', 'supplies.qnty as available_supply')
            ->join('users', 'users.id', '=', 'ris_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'ris_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'ris_supplies.supply_id')
            ->join('requisition_slops', 'requisition_slops.id', '=', 'ris_supplies.ris_id')
            ->where('ris_supplies.department_id', $department->id)
            ->where('ris_supplies.status', 'issued')
            ->whereMonth('ris_supplies.created_at', $month) // Filter by month
            ->whereYear('ris_supplies.created_at', $year)  // Filter by year
            ->orderBy('requisition_slops.ris_number')
            ->get();

        $costs = number_format(
            RisSupplies::where('department_id', $department->id)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->where('status', 'issued')
                ->sum('issued_total_price'),
            2, // Number of decimal places
            '.', // Decimal point
            ',' // Thousands separator
        );
        $count_supplies = RisSupplies::where('department_id', $department->id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'issued')
            ->count();

        $stocks_data = ReceivedSupply::GetIssuedSuppliesReport($request->month, $request->year, $department->id);

        return response(compact('data', 'department', 'costs', 'count_supplies', 'stocks_data'));
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
                'price' => $price,
                'ris_id' => $receive->id,
                'department_id' => auth()->user()->department_id,
            ]);
        });
    }

    public function submitForm(RequisitionSlop $requesition)
    {
        $requesition->submit = 1;
        $requesition->save();

        $data = [
            'action' => 'RIS Submission ('.$requesition->ris_number.')',
            'type' => 'RIS'
        ];
        event(new AuditStoreEvent($data));
    }

    public function approveForm(RequisitionSlop $requesition)
    {
        $requesition->status = 'issued';
        $requesition->submit = 1;
        $requesition->approved_by = auth()->user()->id;
        $requesition->approved_date = Date::now();
        $requesition->save();

        $data = [
            'action' => 'RIS Approve ('.$requesition->ris_number.')',
            'type' => 'RIS'
        ];
        event(new AuditStoreEvent($data));
    }
}
