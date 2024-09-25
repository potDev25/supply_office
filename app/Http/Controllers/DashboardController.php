<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\PurchaseDocument;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index() {
    // departments: 0,
    // po: 0,
    // pr: 0,
    // users: 0,

    $numbers = [
        'departments' => Department::count(),
        'po' => PurchaseDocument::where('po_status', 'done')->count(),
        'pr' => PurchaseDocument::where('pr_status', 'done')->count(),
        'users' => User::where('role', '!=', 'general admin')->count(),
    ];

    return response($numbers);
   }
}
