<?php

namespace App\Http\Controllers\api;
use App\Models\Allergies ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User ;
use App\Models\Medecin ;
use App\Models\Patient ;


use App\Http\Requests\RegisterRequest ;

use App\Http\Resources\UserResource ;
use App\Http\Resources\MedecinResource ;
use App\Http\Resources\PatientResource ;

use App\Http\Resources\FichierMedecinResource ;
use App\Http\Resources\FichierPatientResource ;

use App\Http\Controllers\Api\MedecinController ;
use App\Http\Controllers\Api\PatientController ;

use App\Http\Controllers\Api\FichierMedecinController ;
use App\Http\Controllers\Api\FichierPatientController ;



use Illuminate\Support\Facades\Storage;
use Swift_TransportException;

//use OwenIt\OTP\OTP;
//use ParagonIE\RandomCompat\Random;
use Illuminate\Support\Str;



use App\Mail\WelcomeMail;
use App\Models\VerifyToken;

use Illuminate\Support\Carbon;

use Mail;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;



use Illuminate\Support\Facades\Hash;





class RegisterController extends Controller
{

    public function sendOtp($user)
    {
        $otp =rand(1000, 9999);;
        $time = time();
        /* update le row  */
        VerifyToken::create([
            'email' => $user->email,
            'token' => $otp,
            'created' => time()
        ]);
        $data['email'] = $user->email;
        $data['title'] = 'Mail Verification';
        $data['body'] = 'Your OTP is:- '.$otp;

        try {

            Mail::raw($data['body'], function ($message) use ($data) {
                $message->to( $data['email'])->subject($data['title']);
            });
        } catch (Swift_TransportException $e) {
         return response()->json(['success' => false, 'msg' => 'Failed to send email: ' . $e->getMessage()]);
        }

    }
    
    public function register(Request $request){


        /* ----store in session all datas ---- */
           $user = User::create([
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'number'=>$request->number,
            'ddn'=>$request->ddn,
            'role_id'=>$request->role,
            'email'=>$request->email,
            'address'=>$request->address,
            'password'=>bcrypt($request->password),
            'speciality_id'=>$request->speciality_id,
            'hopital_id'=>$request->hopital_id,
            'file'=>$request->file('file'),

        ]); 
        
        $userallergies = $user;
        $this->sendOtp($user);
 
        $token = JWTAuth::fromUser($user);


        $hopital_id=$request->hopital_id ;
        $speciality_id=$request->speciality_id ;
        $allergies_id = $request->get('allergies_id', []);

        if (is_string($allergies_id)) {
            $allergies_id = explode(',', $allergies_id);
        }

        if($request->role ==3){
            $patientController = new PatientController ;
            $patient = $patientController->createpatient($user ,$allergies_id) ;
            $patient_id = $patient->id ;
            $fichierpatientController = new FichierPatientController;
            $file = $request->file('file');
            $email = $request->email;

            $fichier = $fichierpatientController->createFichier($file, $patient_id);
            $file_path = $fichier->resource['file_path'];
            $file_name = $fichier->resource['file_name'];

            $patientaller = Patient::with('allergies')->findOrFail($user->patient->id);

          
            return response()->json([
                'message' => 'patient created',
                'data' => $user->patient,
                'dataallergies' => $patientaller->allergies ,


                'token' => $token,
        
            ],201);

        }

        if($request->role ==2){
            $medecinController = new MedecinController ;
            $medecin = $medecinController->createmedecin($user ,$hopital_id,$speciality_id) ;
            $medecin_id = $medecin->id ;
            $fichierMedecinController = new FichierMedecinController;
            $file = $request->file('file');
            $fichier = $fichierMedecinController->createFichier($file, $medecin_id);
            $file_path = $fichier->resource['file_path'];
            $file_name = $fichier->resource['file_name'];
            return response()->json([
                'message' => 'medecin created',
                'data' => $user->medecin,
                'user' => $user,
                'file'=>$file_name,
                'fie-P'=>$file_path,


                'token' => $token,
        
            ],201);
        }    
        //return $user->medecin ;
       
    }

    public function verifiedOtp(Request $request)
    {

        $otpData = VerifyToken::where('token',$request->otp)->first();
        $email = $otpData->email ;
        $user = User::where('email',$email)->first();
        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'You entered wrong OTP'],422);
        }
        else{

            $currentTime = Carbon::now();
            $time = $otpData->created_at;
            $timeDifference = $currentTime->diffInSeconds($time);
            $otpExpiryTime = 5000; 

            if ($timeDifference <= $otpExpiryTime) {
               User::where('id', $user->id)->update([
                    'is_activated' => 1
                ]); 
                //dd($user);
                return response()->json(['success' => true, 'msg' => 'Mail has been verified' ,'data' =>$user],200);
            } else {
                return response()->json(['success' => false, 'msg' => 'Your OTP has been Expired'],422);
            }

        }
    }

    public function resendOtp(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        $otpData = VerifyToken::where('email', $request->email)->first();

        if (!$otpData) {
            return response()->json(['success' => false, 'message' => 'OTP data not found.'], 404);
        }

        $currentTime = time();
        $otpCreatedTime = strtotime($otpData->created_at);

        if ($currentTime >= $otpCreatedTime && $otpCreatedTime >= $currentTime - 90) {
            return response()->json(['success' => false, 'message' => 'Please try again later.'], 400);
        } else {
            $this->sendOtp($user);
            return response()->json(['success' => true, 'message' => 'OTP has been sent again.']);
        }
      
    }
    public function searchById($id)
    {
        // Search for the user with the given ID in the database
        $user =User::find($id);

        if ($user) {
            // If the user is found, return the user details
            return response()->json(['status' => 'success', 'data' => $user]);
        } else {
            // If the user is not found, return a 404 response
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }


    }
       

}
