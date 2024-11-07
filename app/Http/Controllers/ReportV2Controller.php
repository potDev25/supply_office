<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportV2Collection;
use App\Models\Department;
use App\Models\RisSupplies;
use Illuminate\Http\Request;

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

        return response(compact('department_data', 'departments'));
    }
}
