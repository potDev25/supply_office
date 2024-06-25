<?php

    namespace App\Http\Services;
    use App\Models\Campaign;
    use App\Models\CampaignView;
    use App\Models\DailyTimeRecord;
    use App\Models\EmployeeProfile;
    use App\Models\Program;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;

    class DailyTimeRecordServiceTest1 {
        //get programs / account names without filter
        public function get_programs($request){
            if(isset($request->limit)){
                $programs = Program::select('programName', 'id')
                    ->distinct()->orderBy('programName', 'ASC')
                    ->paginate($request->limit);
            }else{
                $programs = Program::select('programName', 'id')
                    ->distinct()
                    ->orderBy('programName', 'ASC')
                    ->paginate(10);
            }

            return $programs;
        }

        //get program with specific program id
        public function get_search_programs($program_id){
            $programs = Program::select('programName', 'id')->where('id', $program_id)->distinct()->orderBy('programName', 'ASC')->get();
            return $programs;
        }

        /**
         * Initialize json format
         */
        public function get_data_dtr($programs, $final_data = [], $distinct_dates){
            foreach ($programs as $program_key => $program) {
                
                //first json layer
                $final_data[$program_key] = [
                    'key'              => $program->id,
                    'description'      => 'Program / Account',
                    //Account name / Program Name
                    'name'             => $program->programName,
                    'total_ot_hours'   => 0,
                    'total_hours'      => 0,
                    'billable_hours'   => 0,
                    'approved_hours'   => 0,
                    'premium_hours'    => 0,
                    'children'         => []  
                ];
                
                foreach ($distinct_dates as $date) {
                    $final_data[$program_key]['ot_hours_' . $date] = 0;
                }
                foreach ($distinct_dates as $date) {
                    $final_data[$program_key]['total_hours_' . $date] = 0;
                }
                foreach ($distinct_dates as $date) {
                    $final_data[$program_key]['billable_hours_' . $date] = 0;
                }
                //end first json layer
        
                /**
                 * get campaigns undeer account name / program name
                 * 1st children json
                 */
                $campaigns = Campaign::where('account_id', $program->id)->get();
                if(count($campaigns) > 0){
                    foreach ($campaigns as $campaign_key => $campaign) {
                        $final_data[$program_key]['children'][$campaign_key] = [
                            'key'              => $program->id .'-'. $campaign->id,
                            'campaign_id'      => $campaign->id,
                            'description'      => 'Campaign name',  
                            'name'             => $campaign->campaign_name,
                            'total_ot_hours'   => 0,
                            'total_hours'      => 0,
                            'billable_hours'   => 0,
                            'approved_hours'   => 0,
                            'premium_hours'    => 0,
                            //Campaign Name
                            'children'         => []  
                        ];
    
                        foreach ($distinct_dates as $date) {
                            $final_data[$program_key]['children'][$campaign_key]['ot_hours_' . $date]       = 0;
                        }
                        foreach ($distinct_dates as $date) {
                            $final_data[$program_key]['children'][$campaign_key]['total_hours_' . $date]    = 0;
                        }
                        foreach ($distinct_dates as $date) {
                            $final_data[$program_key]['children'][$campaign_key]['billable_hours_' . $date] = 0;
                        }
                        //end 1st children json
                    }

                    EmployeeProfile::where('campaignID', $campaign->id)->chunk(100, function($agents) use (&$final_data, $program_key, $campaign_key, &$campaign, $distinct_dates, $program){
                        foreach ($agents as $agent_key => $agent) {
                            $name = EmployeeProfile::select('fName', 'mName', 'lName')->where('id', $agent->id)->firstOrFail();
                            $final_data[$program_key]['children'][$campaign_key]['children'][$agent_key] = [
                                'key'                  => $program->id .'-'. $campaign->id .'-'.$agent->id,
                                'emp_id'               => $agent->id, 
                                'description'          => 'Agents / Employee',
                                //Agent Name / Employee Name
                                'name'                 => $name->fName . ' ' . $name->lName . ' ' . $name->mName,
                                'total_ot_hours'       => 0,
                                'total_hours'          => 0,
                                'billable_hours'       => 0,
                                'approved_hours'       => 0,
                                'premium_hours'        => 0,
                            ];
    
                            foreach ($distinct_dates as $date) {
                                $final_data[$program_key]['children'][$campaign_key]['children'][$agent_key]['ot_hours_' . $date] = 0;
                            }
                            foreach ($distinct_dates as $date) {
                                $final_data[$program_key]['children'][$campaign_key]['children'][$agent_key]['total_hours_' . $date] = 0;
                            }
                            foreach ($distinct_dates as $date) {
                                $final_data[$program_key]['children'][$campaign_key]['children'][$agent_key]['billable_hours_' . $date] = 0;
                            }
                        }
                    });
                }
            }

            return $final_data;
        }

        public function get_campaign_data($final_data = [], $distinct_dates){
            $program_ids = [];

            for ($i=0; $i < count($final_data); $i++) { 
                $program_ids[] = $final_data[$i]['key'];
            }

            Campaign::whereIn('account_id', $program_ids)->chunk(200, function($campaigns) use ($final_data, $distinct_dates){
                for ($i=0; $i < count($final_data); $i++) { 
                    $prog_id = $final_data[$i]['key'];
                    foreach ($campaigns as $campaign_key => $campaign) {
                        if($campaign->account_id == $prog_id){
                            $final_data[$i]['children'][$campaign_key] = [
                                'key'              => $final_data[$i]['key'] .'-'. $campaign->id,
                                'campaign_id'      => $campaign->id,
                                'description'      => 'Campaign name',  
                                'name'             => $campaign->campaign_name,
                                'total_ot_hours'   => 0,
                                'total_hours'      => 0,
                                'billable_hours'   => 0,
                                'approved_hours'   => 0,
                                'premium_hours'    => 0,
                                //Campaign Name
                                'children'         => []  
                            ];
        
                            foreach ($distinct_dates as $date) {
                                $final_data[$i]['children'][$campaign_key]['ot_hours_' . $date]       = 0;
                            }
                            foreach ($distinct_dates as $date) {
                                $final_data[$i]['children'][$campaign_key]['total_hours_' . $date]    = 0;
                            }
                            foreach ($distinct_dates as $date) {
                                $final_data[$i]['children'][$campaign_key]['billable_hours_' . $date] = 0;
                            }
                        }
                    }
                }
            });

            return $final_data;
        }

        public function get_agent_data($final_data = [], $distinct_dates)
        {
            $cam_ids = [];
            foreach ($final_data as $data) {
                foreach ($data['children'] as $child) {
                    $cam_ids[] = $child['campaign_id'];
                }
            }

            // Using chunking to process the data in batches
            EmployeeProfile::whereIn('campaignID', $cam_ids)->chunk(200, function($agents) use (&$final_data, $distinct_dates) {
                for ($i = 0; $i < count($final_data); $i++) {
                    foreach ($final_data[$i]['children'] as $campaign_key => $campaigns) {
                        $camp_id = $campaigns['campaign_id'];
                        foreach ($agents as $agent_key => $agent) {
                            if($agent->campaignID == $camp_id){
                                $final_data[$i]['children'][$campaign_key]['children'][$agent_key] = [
                                    'key'                  => $final_data[$i]['key'] . '-' . $agent->campaignID . '-' . $agent->id,
                                    'emp_id'               => $agent->id,
                                    'description'          => 'Agents / Employee',
                                    'name'                 => $agent->fName . ' ' . $agent->lName . ' ' . $agent->mName,
                                    'total_ot_hours'       => 0,
                                    'total_hours'          => 0,
                                    'billable_hours'       => 0,
                                    'approved_hours'       => 0,
                                    'premium_hours'        => 0,
                                ];
                                foreach ($distinct_dates as $date) {
                                    $final_data[$i]['children'][$campaign_key]['children'][$agent_key]['ot_hours_' . $date] = 0;
                                }
                                foreach ($distinct_dates as $date) {
                                    $final_data[$i]['children'][$campaign_key]['children'][$agent_key]['total_hours_' . $date] = 0;
                                }
                                foreach ($distinct_dates as $date) {
                                    $final_data[$i]['children'][$campaign_key]['children'][$agent_key]['billable_hours_' . $date] = 0;
                                }
                            }

                        }
                    }
                }
            });

            return $final_data;
        }


        /**
         * get all data from dtr table for all specific employee and dates
         */
        public function get_total_hours($final_data = [], $date){
            // Collect all employee IDs from the nested structure
            $emp_ids = [];
            foreach ($final_data as $data) {
                foreach ($data['children'] as $child) {
                    foreach ($child['children'] as $value) {
                        $emp_ids[] = $value['emp_id'];
                    }
                }
            }
        
            // Retrieve all necessary data in a single query and group by emp_id and date
            $dates = DailyTimeRecord::select('emp_id', 'date', 'total_ot_hrs', 'total_hrs', 'billable')
                ->whereIn('emp_id', $emp_ids)
                ->whereBetween(DB::raw('DATE(date)'), [$date['start_date'], $date['end_date']])
                ->get()
                ->groupBy(function($item) {
                    return $item->emp_id . '_' . $item->date;
                });
        
            // Iterate over the final_data to fill in the hours
            foreach ($final_data as &$data) {
                foreach ($data['children'] as &$child) {
                    foreach ($child['children'] as &$value) {
                        $emp_id = $value['emp_id'];
                        foreach ($dates as $key => $dateGroup) {
                            foreach ($dateGroup as $date) {
                                if ($date->emp_id == $emp_id) {
                                    $value['ot_hours_'.$date->date]       = (float) $date->total_ot_hrs;
                                    $value['total_hours_'.$date->date]    = (float) $date->total_hrs;
                                    $value['billable_hours_'.$date->date] = (float) $date->billable;
                                }
                            }
                        }
                    }
                }
            }
        
            return $final_data;
        }

        /**
         * for campaign totals per day=> 
            * calculate total_hours, 
            * calculate total_ot_hours
            * calculcate total_billable_hours
         */
        public function campaign_total_hours($final_data = [], $date_data){
            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($final_data[$i]['children'] as $campaign_key  => $campaign){
                    foreach($campaign['children'] as $agent_key => $agent){
                        foreach($date_data as $date){
                            $final_data[$i]['children'][$campaign_key]['ot_hours_' . $date]       += $agent['ot_hours_' . $date];
                            $final_data[$i]['children'][$campaign_key]['total_hours_' . $date]    += $agent['total_hours_' . $date];
                            $final_data[$i]['children'][$campaign_key]['billable_hours_' . $date] += $agent['billable_hours_' . $date];
                        }
                    }
                }
            }

            return $final_data;
        }

        /**
         * for program totals per day => 
            * calculate total_hours, 
            * calculate total_ot_hours
            * calculcate total_billable_hours
         */
        public function program_total_hours($final_data = [], $date_data){
            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($final_data[$i]['children'] as $campaign_key  => $campaign){
                    foreach($date_data as $date){
                        $final_data[$i]['ot_hours_' . $date]         += $campaign['ot_hours_' . $date];
                        $final_data[$i]['total_hours_' . $date]      += $campaign['total_hours_' . $date];
                        $final_data[$i]['billable_hours_' . $date]   += $campaign['billable_hours_' . $date];
                    }
                    $final_data[$i]['approved_hours'] += $campaign['approved_hours'];
                }
            }

            return $final_data;
        }

        /**
         * get totals for total footer part
         */
        public function get_total_footer($footer_total_data = [], $final_data = [], $dates){
            foreach ($dates as $date) {
                $footer_total_data['total_ot_hrs_footer_' . $date]      = 0; 
                $footer_total_data['total_hrs_footer_' . $date]         = 0; 
            }
            $footer_total_data['total_hours_row_footer']                = 0;
            $footer_total_data['total_ot_hours_row_footer']             = 0;
            $footer_total_data['billable_hours_footer']                 = 0;
            $footer_total_data['approved_hours_footer']                 = 0;
            $footer_total_data['premium_hours_footer']                  = 0;

            for ($i=0; $i < count($final_data); $i++) { 
                foreach ($dates as $date) {
                    $footer_total_data['total_ot_hrs_footer_' . $date]  += $final_data[$i]['ot_hours_' . $date];
                    $footer_total_data['total_hrs_footer_' . $date]     += $final_data[$i]['total_hours_' . $date];
                }
                $footer_total_data['total_hours_row_footer']            += $final_data[$i]['total_hours'];
                $footer_total_data['total_ot_hours_row_footer']         += $final_data[$i]['total_ot_hours'];
                $footer_total_data['approved_hours_footer']             += $final_data[$i]['approved_hours'];
                $footer_total_data['premium_hours_footer']              += $final_data[$i]['premium_hours'];
                $footer_total_data['billable_hours_footer']             += $final_data[$i]['billable_hours'];
            }

            return $footer_total_data;
        }

        /**
         * for agent totals over all => 
            * calculate total_hours, 
            * calculate total_ot_hours
            * calculcate total_billable_hours
         */
        public function calculate_agent_total_row($final_data = [], $dates){
            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($final_data[$i]['children'] as $campaign_key  => $campaign){
                    foreach($campaign['children'] as $agent_key => $agent){
                        foreach($dates as $date){
                            $final_data[$i]['children'][$campaign_key]['children'][$agent_key]['total_ot_hours']  += $agent['ot_hours_' . $date];
                            $final_data[$i]['children'][$campaign_key]['children'][$agent_key]['total_hours' ]    += $agent['total_hours_' . $date];
                            $final_data[$i]['children'][$campaign_key]['children'][$agent_key]['billable_hours' ] += $agent['billable_hours_' . $date];
                        }
                    }
                }
            }

            return $final_data;
        }

        /**
         * for campaign totals over all => 
            * calculate total_hours, 
            * calculate total_ot_hours
            * calculcate total_billable_hours
         */
        public function calculate_campaign_total_row($final_data = [], $dates, $date_array){
            $campaign_ids = [];
            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($final_data[$i]['children'] as $campaign_key  => $campaign){
                    $campaign_ids[] = $campaign['campaign_id'];
                    foreach($dates as $date){
                        $final_data[$i]['children'][$campaign_key]['total_ot_hours']  += $campaign['ot_hours_' . $date];
                        $final_data[$i]['children'][$campaign_key]['total_hours' ]    += $campaign['total_hours_' . $date];
                        $final_data[$i]['children'][$campaign_key]['billable_hours' ] += $campaign['billable_hours_' . $date];
                    }
                }
            }

            $dates_1 = CampaignView::select('Date', 'campaign_id', 'apprived_Hours', 'Date')
                ->whereIn('campaign_id', $campaign_ids)
                ->where('Date', $date_array['start_date'])
                ->get()
                ->groupBy('campaign_id');

            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($final_data[$i]['children'] as $campaign_key  => $campaign){
                    $camp_id = $campaign['campaign_id'];
                    if(isset($dates_1[$camp_id])){
                        foreach($dates_1[$camp_id] as $date){
                            $approved_hours = CampaignView::where('Date', $date->Date)->where('campaign_id', $camp_id)->firstOrFail();
                            $final_data[$i]['children'][$campaign_key]['approved_hours'] += isset($approved_hours) ? (float)$approved_hours->apprived_Hours : 0;
                        }
                    }
                }
            }

            return $final_data;
        }

        /**
         * for program totals over all => 
            * calculate total_hours, 
            * calculate total_ot_hours
            * calculcate total_billable_hours
         */
        public function calculate_program_total_row($final_data = [], $dates){
            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($dates as $date){
                    $final_data[$i]['total_ot_hours']      += $final_data[$i]['ot_hours_' . $date];
                    $final_data[$i]['total_hours' ]        += $final_data[$i]['total_hours_' . $date];
                    $final_data[$i]['billable_hours' ]     += $final_data[$i]['billable_hours_' . $date];
                }
            }

            return $final_data;
        }

        public function test($final_data = [], $dates, $startDate, $endDate){
            $campaign_ids = [];
            $shit = [];
            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($final_data[$i]['children'] as $campaign_key  => $campaign){
                    $campaign_ids[] = $campaign['campaign_id'];
                    foreach($dates as $date){
                        $final_data[$i]['children'][$campaign_key]['total_ot_hours'] += $campaign['ot_hours_' . $date];
                        $final_data[$i]['children'][$campaign_key]['total_hours' ] += $campaign['total_hours_' . $date];

                        // $final_data[$i]['children'][$campaign_key]['approved_hours'] = 1212;
                    }
                }
            }

            $dates_1 = CampaignView::select('Date', 'campaign_id', 'apprived_Hours', 'campaign_name')
                ->whereIn('campaign_id', $campaign_ids)
                ->where('Date','2024-01-08')
                ->get()
                ->groupBy('campaign_id');

            for ($i = 0; $i < count($final_data); $i++) { 
                foreach($final_data[$i]['children'] as $campaign_key  => $campaign){
                    $camp_id = $campaign['campaign_id'];
                    if(isset($dates_1[$camp_id])){
                        foreach($dates_1[$camp_id] as $date){
                            $approved_hours = CampaignView::where('date', $date->Date)->where('campaign_id', $camp_id)->firstOrFail();
                            $shit[] = [
                                'hours' => $approved_hours,
                                'campaign_id' => $camp_id,
                                'date' => $date->Date
                            ];
                            $final_data[$i]['children'][$campaign_key]['approved_hours'] += isset($approved_hours->apprived_hours) ? $approved_hours->apprived_Hours : 1;
                        }
                    }
                }
            }

            $dates_1 = CampaignView::where('date', '2024-01-08')->where('campaign_id', 142)->firstOrFail()->apprived_hours;
            return $final_data;
        }

        public function getDate($request) : array{
            $date = [
                'start_date' => '2024-01-08',
                'end_date' => '2024-01-14'
            ];

            if(isset($request->start_date) && isset($request->end_date)){
                $date = [
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ];
            }

            return $date;
        }
        
    }