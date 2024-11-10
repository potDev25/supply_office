<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReceivedSupply extends Model
{
    use HasFactory;

    public static function GetSuppliesByMonthYear($month, $year){
        return DB::select('CALL GetSuppliesByMonthYear(?, ?)', [$year, $month]);
    }

    public static function GetTotalPriceByStatusAndMonthYear($month, $year){
        return DB::select('CALL GetTotalPriceByStatusAndMonthYear(?, ?)', [$month, $year]);
    }

    public static function GetIssuedSuppliesReport($month, $year, $dep_id){
        return DB::select('CALL GetIssuedSuppliesReport(?, ?, ?)', [$dep_id, $month, $year]);
    }
}
