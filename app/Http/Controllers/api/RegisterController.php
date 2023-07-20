<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User ;
use App\Models\Medecin ;

use App\Http\Requests\RegisterRequest ;

use App\Http\Resources\UserResource ;
use App\Http\Resources\MedecinResource ;
use App\Http\Resources\FichierMedecinResource ;


use App\Http\Controllers\Api\MedecinController ;
use App\Http\Controllers\Api\FichierMedecinController ;


use Illuminate\Support\Facades\Storage;





class RegisterController extends Controller
{
    /* fonction register */
    public function register(Request $request){

           $user = User::create([

            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'number'=>$request->number,
            'ddn'=>$request->ddn,
            'role_id'=>$request->role,
            'email'=>$request->email,
            'address'=>$request->address,
            'password'=>bcrypt('$request->password'),
            'speciality_id'=>$request->speciality_id,
            'hopital_id'=>$request->hopital_id,

        ]);  
        $hopital_id=$request->hopital_id ;
        $speciality_id=$request->speciality_id ;

        if($request->role ==2){
           $medecinController = new MedecinController ;
            $medecin = $medecinController->createmedecin($user ,$hopital_id,$speciality_id) ;
            $medecin_id = $medecin->id ;

            $fichierMedecinController = new FichierMedecinController;

            // Upload the file and get the FichierMedecinResource
            $file = $request->file('file');
            $fichier = $fichierMedecinController->createFichier($file, $medecin_id);

            // Get the file_path from the FichierMedecinResource
            $file_path = $fichier->resource['file_path'];
            $file_name = $fichier->resource['file_name'];

           
        }  
        return response()->json([
            $user->medecin,
            'medecin_id' => $medecin_id,
            'file_path' => $file_path,
            'file_name' => $file_name,

        ]);
       
 

    }

}
