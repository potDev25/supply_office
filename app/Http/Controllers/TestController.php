<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use App\Models\EmployeeProfile;
use App\Models\Program;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        /**
         * Get programs / accounts
         */
        $programs = Program::select('id','programName')->orderBy('programName', 'ASC')->paginate(20);
        $final_data = [];

        foreach ($programs as $program_key => $program) {
            /**
             * Get campagin under programs or accounts
             */
            $campaigns = Campaign::select('id','campaign_name')->where('account_id', $program->id)->get();
            /**
             * Loop Campaigns
             */
            foreach ($campaigns as $campaign_key => $campaign) {
                /**
                 * Get employees / agent under campaign
                 */
                $employees = EmployeeProfile::select('id', 'emp_id', 'fName', 'mName', 'lName')->where('campaignID', $campaign->id)->get();
                $camp = Campaign::select('id','campaign_name')->where('id', $campaign->id)->first();
                $final_data[] = [
                    'key' => $program_key + $campaign->id,
                    'program_name' => $program->programName,
                    'children' => [
                        'key' => $program_key .'-'. $camp->id,
                        'campaign_name' => Campaign::select('id','campaign_name')->where('id', $campaign->id)->first(),
                        'children' => [
                            'key' => $program_key .'-'. $campaign_key .'-'. $campaign_key + 1,
                            'agent_name' =>  $employees,
                            'total_hours' => '12',
                            'ot_hours' => '12',
                        ],
                    ],
                ];
                // foreach ($employees as $key => $agent) {
                    
                // }
            }

        }

        return response(compact('final_data'));
    }
}
