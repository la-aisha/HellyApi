<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FichierPatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_name'=>'required|min:20',
            'file_path'=>'required|min:3',
            'status'=>'required|min:9',
            'patient_id'=>'required|integer:1',
            'created_at'
        ];
    }
}
