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
//use OwenIt\OTP\OTP;
//use ParagonIE\RandomCompat\Random;
use Illuminate\Support\Str;



use App\Mail\WelcomeMail;
use App\Models\VerifyToken;


use Illuminate\Support\Carbon;


use Mail;







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
        Mail::raw($data['body'], function ($message) use ($data) {
            $message->to( $data['email'])->subject($data['title']);
        });
    }
    
    /* fonction register */
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
            'password'=>bcrypt('$request->password'),
            'speciality_id'=>$request->speciality_id,
            'hopital_id'=>$request->hopital_id,
            'file'=>$request->file('file'),

        ]);   

        $hopital_id=$request->hopital_id ;
        $speciality_id=$request->speciality_id ;
        if($request->role ==2){
            $medecinController = new MedecinController ;
            $medecin = $medecinController->createmedecin($user ,$hopital_id,$speciality_id) ;
            $medecin_id = $medecin->id ;
            $fichierMedecinController = new FichierMedecinController;
            $file = $request->file('file');
            $fichier = $fichierMedecinController->createFichier($file, $medecin_id);
            $file_path = $fichier->resource['file_path'];
            $file_name = $fichier->resource['file_name'];
        }    
        $this->sendOtp($user);
        //return $user->medecin ;
         return response()->json([
        'message' => 'user created',
        'data' => $user->medecin,
        'status' => 201,
    ]);
    }

    public function verifiedOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = VerifyToken::where('token',$request->otp)->first();
        if(!$otpData){
            return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
        }
        else{

            $currentTime = Carbon::now(); // Get the current time using Carbon

            // Get the time when the OTP was created from the $otpData object
            $time = $otpData->created_at;

            // Perform the time comparison using Carbon methods
            $timeDifference = $currentTime->diffInSeconds($time);
            $otpExpiryTime = 3600; // 90 seconds + 5 seconds buffer

            if ($timeDifference <= $otpExpiryTime) {
                User::where('id', $user->id)->update([
                    'is_activated' => 1
                ]);
                return response()->json(['success' => true, 'msg' => 'Mail has been verified']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Your OTP has been Expired']);
            }

        }
    }

    public function resendOtp(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        $otpData = VerifyToken::where('email',$request->email)->first();

        $currentTime = time();
        $time = $otpData->created_at;

        if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
            return response()->json(['success' => false,'msg'=> 'Please try after some time']);
        }
        else{

            $this->sendOtp($user);//OTP SEND
            return response()->json(['success' => true,'msg'=> 'OTP has been sent']);
        }

    }
       

}
