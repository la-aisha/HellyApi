<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User ;
use App\Models\Medecin ;

use App\Http\Resources\MedecinResource ;




class MedecinController extends Controller
{
    public function createmedecin(User $user,int $hopital,int $specialite ){
       // $resquest = new Request ;
       $medecin= Medecin::create([
        'firstname'=>$user->firstname,
        'lastname'=>$user->lastname,
        'ddn'=>$user->ddn,
        'email'=>$user->email,
        'number'=>$user->number,
        'address'=>$user->address,
        /* ------- */
        'speciality_id'=>$specialite,
        'hopital_id'=>$hopital, 

        'user_id'=>$user->id,

        ]);
        
        return new MedecinResource($medecin);

        
       // $res= $user->hopital_id ;
       // return $res ;

 
    }
}
