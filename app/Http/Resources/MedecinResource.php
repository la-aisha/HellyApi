<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedecinResource extends JsonResource
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

            'speciality_id'=> $this->id ,
            'hopital_id'=>$this->hopital_id ,
            'user_id'=>$this->user_id ,

        ];
    }
}
