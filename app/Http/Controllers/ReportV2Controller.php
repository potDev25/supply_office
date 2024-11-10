<?php

namespace App\Http\Controllers;

use App\Exports\MonthReportExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportV2Collection;
use App\Models\Department;
use App\Models\RisSupplies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportV2Controller extends Controller
{
    public function index(Request $request)
    {
        $department_data = [];
        $month = $request->query('month', now()->month); // Default to current month if not provided
        $year = $request->query('year', now()->year); // Default to current year if not provided
        $limit = $request->query('limit', 10); // Default pagination limit if not provided

        $departments = Department::paginate($limit);

        foreach ($departments as $value) {
            $department_data[] = [
                'department_id' => $value->id,
                'department_name' => $value->department_name,
                'total' => RisSupplies::where('department_id', $value->id)
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->where('status', 'issued')
                    ->count(),
                'costs' => number_format(
                    RisSupplies::where('department_id', $value->id)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->where('status', 'issued')
                        ->sum('issued_total_price'),
                    2, // Number of decimal places
                    '.', // Decimal point
                    ',' // Thousands separator
                ),
            ];
        }


        $data = RisSupplies::select(
            'departments.department_name',
            'requisition_slops.ris_number',
            'ris_supplies.supply_name',
            'supplies.description',
            'categories.name',
            'supplies.unit',
            'supplies.qnty as available_supply',
            'ris_supplies.issued_total_price',
            DB::raw('ris_supplies.issued_total_price * ris_supplies.issued_qnty as total_costs'),
            'ris_supplies.created_at',

        )
            ->join('users', 'users.id', '=', 'ris_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'ris_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'ris_supplies.supply_id')
            ->join('requisition_slops', 'requisition_slops.id', '=', 'ris_supplies.ris_id')
            ->join('departments', 'ris_supplies.department_id', '=', 'departments.id')
            ->where('ris_supplies.status', 'issued')
            ->whereMonth('ris_supplies.created_at', $month) // Filter by month
            ->whereYear('ris_supplies.created_at', $year)  // Filter by year
            ->orderBy('requisition_slops.ris_number')
            ->get();

        return response(compact('department_data', 'departments', 'data'));
    }

    public function export(Request $request)
    {
        $month = $request->query('month', now()->month); // Default to current month if not provided
        $year = $request->query('year', now()->year);
        $data = RisSupplies::select(
            'departments.department_name',
            'requisition_slops.ris_number',
            'ris_supplies.supply_name',
            'supplies.description',
            'categories.name',
            'supplies.unit',
            'ris_supplies.issued_qnty as available_supply',
            'ris_supplies.issued_total_price',
            DB::raw('ris_supplies.issued_total_price * ris_supplies.issued_qnty as total_costs'),
            'ris_supplies.created_at',

        )
            ->join('users', 'users.id', '=', 'ris_supplies.user_id')
            ->join('categories', 'categories.id', '=', 'ris_supplies.category_id')
            ->join('supplies', 'supplies.id', '=', 'ris_supplies.supply_id')
            ->join('requisition_slops', 'requisition_slops.id', '=', 'ris_supplies.ris_id')
            ->join('departments', 'ris_supplies.department_id', '=', 'departments.id')
            ->where('ris_supplies.status', 'issued')
            ->whereMonth('ris_supplies.created_at', $month) // Filter by month
            ->whereYear('ris_supplies.created_at', $year)  // Filter by year
            ->orderBy('requisition_slops.ris_number')
            ->get();

        $monthName = \Carbon\Carbon::create()->month($month)->format('F');

        $file_name = $monthName . ',' . $year . '-Monthly Report.xlsx';

        return Excel::download(new MonthReportExport($data), $file_name);
    }
}
