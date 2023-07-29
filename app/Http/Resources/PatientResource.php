<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id'=> $this->id ,
            'firstname'=>$this->firstname ,
            'lastname'=>$this->lastname ,
            'ddn'=>$this->ddn ,
            'email'=>$this->email ,

            'allergies_id'=>$this->allergies_id,
            'user_id'=>$this->user_id ,


        ];
    }
}
