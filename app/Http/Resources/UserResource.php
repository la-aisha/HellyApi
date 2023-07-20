<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'token'=>$this->createToken("token")->plainTextToken ,
            'role_id'=>$this->role_id,

        ]
        ;
    }

}
