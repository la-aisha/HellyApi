<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Allergies ;
use App\Http\Resources\AllergiesResource ;

class AllergiesController extends Controller
{
    //

   function getAllAllergies(){
     $allergies = Allergies::all();
     return response()->json($allergies);




    }
}
