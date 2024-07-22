<?php

namespace App\Http\Resources;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'department_name' => $this->department_name,
            'logo' => $this->logo,
            'department_type' => $this->department_type,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'files' => Document::where('department_id', $this->id)->count(),
            'date' => $this->get_date($request)
        ];
    }

    public function get_date($request){
        $date = Carbon::now()->format('F'); ;
        if(isset($request->date)){
            return $request->date;
        }

        return $date;
    }
}
