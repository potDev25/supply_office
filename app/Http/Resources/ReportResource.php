<?php

namespace App\Http\Resources;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
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
            'files' => Document::where('department_id', $this->id)->whereMonth('date_complied', $this->get_date($request))->count(),
            'document_data' => $this->getDocument($this->id, $request) !== null ? $this->getDocument($this->id, $request) : null
        ];
    }

    public function get_date($request){
        $date = Carbon::now()->format('m');
        if(isset($request->date)){
            return $request->date;
        }

        return $date;
    }

    public function getDocument($department_id, $request){
        $document = Document::where('department_id', $department_id)
        ->whereMonth('date_complied', $this->get_date($request))
        ->first();

        if(isset($document)){
            $data =  Document::select('users.*', 'documents.*', 'documents.id as document_id')
            ->join('users', 'documents.user_id', 'users.id')
            ->where('documents.id', $document->id)
            ->first();
            return $data;
        }

        return null;
    }
}
