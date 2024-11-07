<?php

namespace App\Http\Resources;

use App\Models\RisSupplies;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportV2Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'department_id' => $this->id,
            'department_name' => $this->department_name,
            'total' => RisSupplies::whereMonth('created_at', $request->month)->where('department_id', $this->id)->count()
        ];
    }
}
