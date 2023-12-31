<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User ;
use App\Models\Allergies ;

use App\Models\Patient ;

use App\Http\Resources\PatientResource ;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile; // Import UploadedFile class
use Illuminate\Support\Str;

class PatientController extends Controller
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
       if (!empty($allergies)) {
        $allergyModels = Allergies::whereIn('id', $allergies)->get();
        $patient->allergies()->attach($allergyModels);
    }
            
         return new PatientResource($patient);

    }
}
