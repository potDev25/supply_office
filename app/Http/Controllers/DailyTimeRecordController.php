<?php

namespace App\Http\Controllers;

use App\Http\Services\DailyTimeRecordService;
use App\Http\Services\DailyTimeRecordServiceTest;
use App\Models\Campaign;
use App\Models\DailyTimeRecord;
use App\Models\EmployeeProfile;
use App\Models\Program;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyTimeRecordController extends Controller
{
    protected $dtrService;
    protected $dtrTestService;
    public function __construct(DailyTimeRecordService $dtr_service, DailyTimeRecordServiceTest $dtr_test)
    {
        $this->dtrService = $dtr_service;
        $this->dtrTestService = $dtr_test;
    }

    public function index(Request $request) {
        $final_data          = [];
        $footer_total_data   = [];
        // $startDate           = '2024-01-08';
        // $endDate             = '2024-01-14';
        $date                = $this->dtrService->getDate($request);
        $date_data           = DailyTimeRecord::select(DB::raw('DATE(date) as date'))
                                ->whereBetween(DB::raw('DATE(date)'), [$date['start_date'], $date['end_date']])
                                ->distinct()
                                ->pluck('date');
        $programs       = $this->dtrService->get_programs($request);
        $program_names  = $this->dtrService->get_program_names();
        
        /**
         * call methods from DailyTimeRecordService.php
         */
        $final_data         = $this->dtrService->get_data_dtr($programs, $final_data, $date_data);
        // $final_data         = $this->dtrService->get_campaign_data($final_data, $date_data);
        $final_data         = $this->dtrService->get_agent_data($final_data, $date_data);
        $final_data         = $this->dtrService->get_total_hours($final_data, $date);
        $final_data         = $this->dtrService->calculate_agent_total_row($final_data, $date_data);
        $final_data         = $this->dtrService->campaign_total_hours($final_data, $date_data);
        $final_data         = $this->dtrService->calculate_campaign_total_row($final_data, $date_data, $date);
        $final_data         = $this->dtrService->program_total_hours($final_data, $date_data);
        $final_data         = $this->dtrService->calculate_program_total_row($final_data, $date_data);
        $final_data         = $this->dtrService->calculate_total_amount($final_data);
        
        $footer_total_data = $this->dtrService->get_total_footer($footer_total_data, $final_data, $date_data);
        $program_ids = $request->query('prog_id');
        return response(compact('program_names', 'final_data', 'date_data', 'footer_total_data', 'programs', 'program_ids'));
    }

    public function test_dtr(Request $request){
        $final_data          = [];
        $footer_total_data   = [];
        // $startDate           = '2024-01-08';
        // $endDate             = '2024-01-14';
        $date                = $this->dtrTestService->getDate($request);
        $date_data           = DailyTimeRecord::select(DB::raw('DATE(date) as date'))
                                ->whereBetween(DB::raw('DATE(date)'), [$date['start_date'], $date['end_date']])
                                ->distinct()
                                ->pluck('date');
        $programs       = $this->dtrTestService->get_programs($request);
        
        /**
         * call methods from DailyTimeRecordService.php
         */
        $final_data         = $this->dtrTestService->get_data_dtr($programs, $final_data, $date_data);
        $final_data         = $this->dtrTestService->get_campaign_data($final_data, $date_data);
        $final_data         = $this->dtrTestService->get_agent_data($final_data, $date_data);
        $final_data         = $this->dtrTestService->get_total_hours($final_data, $date);
        $final_data         = $this->dtrTestService->calculate_agent_total_row($final_data, $date_data);
        $final_data         = $this->dtrTestService->campaign_total_hours($final_data, $date_data);
        $final_data         = $this->dtrTestService->calculate_campaign_total_row($final_data, $date_data, $date);
        $final_data         = $this->dtrTestService->program_total_hours($final_data, $date_data);
        $final_data         = $this->dtrTestService->calculate_program_total_row($final_data, $date_data);
        
        $footer_total_data = $this->dtrTestService->get_total_footer($footer_total_data, $final_data, $date_data);
        $r = $request->all();

        return response(compact('program_names', 'final_data', 'date_data', 'footer_total_data', 'programs', 'r'));
    }

    public function test_dtr_one(Request $request){
        $final_data          = [];
        $footer_total_data   = [];
        // $startDate           = '2024-01-08';
        // $endDate             = '2024-01-14';
        $date                = $this->dtrTestService->getDate($request);
        $date_data           = DailyTimeRecord::select(DB::raw('DATE(date) as date'))
                                ->whereBetween(DB::raw('DATE(date)'), [$date['start_date'], $date['end_date']])
                                ->distinct()
                                ->pluck('date');
        $programs       = $this->dtrTestService->get_programs($request);
        
        /**
         * call methods from DailyTimeRecordService.php
         */
        $final_data         = $this->dtrTestService->get_data_dtr($programs, $final_data, $date_data);
        // $final_data         = $this->dtrTestService->get_campaign_data($final_data, $date_data);
        // $final_data         = $this->dtrTestService->get_agent_data($final_data, $date_data);
        $final_data         = $this->dtrTestService->get_total_hours($final_data, $date);
        $final_data         = $this->dtrTestService->calculate_agent_total_row($final_data, $date_data);
        $final_data         = $this->dtrTestService->campaign_total_hours($final_data, $date_data);
        $final_data         = $this->dtrTestService->calculate_campaign_total_row($final_data, $date_data, $date);
        $final_data         = $this->dtrTestService->program_total_hours($final_data, $date_data);
        $final_data         = $this->dtrTestService->calculate_program_total_row($final_data, $date_data);
        
        $footer_total_data = $this->dtrTestService->get_total_footer($footer_total_data, $final_data, $date_data);

        return response(compact('final_data', 'date_data', 'footer_total_data', 'programs'));
    }

    public function getAccounts(){
        $programs = Program::select('programName', 'id')->distinct()->orderBy('programName', 'ASC')->paginate(100);
        return response(compact('programs')); 
    }

    public function getDates(){
        $date_data = [];
        $startDate = '2022-01-16';
        $endDate = '2022-01-22';
        $dates = DailyTimeRecord::select('date')
                ->where('emp_id', '0')
                ->whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])
                ->get();

        foreach ($dates as $key_date => $date) {
            $date_data[] = [
                'title' => $date->date,
                'children' => []
            ];
        }
        return response(compact('dates', 'date_data'));
    }

    public function testFilter(Request $request){
        return response($request->all());
    }
    
    // public function testDate(Request $request) {
    //     $final_data = [];
    //     $date_data = [];
    //     $startDate = Carbon::now()->startOfMonth();
    //     $endDate = '2024-06-12';

    //     if(isset($request->limit)){
    //         $programs = $this->dtrService->get_programs($request->limit);
    //     }else{
    //         $programs = $this->dtrService->get_programs();
    //     }

    //     if(!isset($request->program_id)){
    //         $programs = $this->dtrService->get_programs();
    //     }else{
    //         $programs = $this->dtrService->get_search_programs($request->program_id);
    //     }

    
    //     $final_data = $this->dtrService->get_data_dtr($programs, $final_data);

    //     $final_data = $this->dtrService->calculate_total_hours($final_data);

    //     // for ($i=0; $i < count($final_data); $i++) { 
    //     //     foreach ($final_data[$i]['children'] as $key => $value) {
    //     //         foreach ($value['children'] as $key => $agent) {
    //     //         //    $sample[] = $agent['emp_id'];
    //     //         $dates = DailyTimeRecord::select('date')
    //     //             ->where('emp_id', $agent['emp_id'])
    //     //             ->whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])
    //     //             ->get();
    //     //         }

    //     //         foreach ($dates as $key_date => $date) {
    //     //             $date_data[] = [
    //     //                 'title' => $date->date
    //     //             ];
    //     //         }
    //     //     }
    //     // }
    
    //     return response(compact('final_data', 'date_data'));
    // }
    
}
