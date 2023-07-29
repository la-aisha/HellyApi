<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientAllergy extends Controller
{
    //

    public function createpatient($user , array $allergies){

       


        $patient= Patient::create([
            'firstname'=>$user->firstname,
            'lastname'=>$user->lastname,
            'ddn'=>$user->ddn,
            'email'=>$user->email,
            'number'=>$user->number,
            'address'=>$user->address,
            'allergies_id'=>$allergies, 
            'user_id'=>$user->id,
            'created_at' => now(),

        ]);
       // $patient->allergies()->sync($allergies_id);

            
         return new PatientResource($patient);

    }
}
