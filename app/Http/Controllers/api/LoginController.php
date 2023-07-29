<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



/* ----importer ---- */
use App\Http\Requests\LoginRequest ;
use App\Http\Resources\UserResource ;
use App\Http\Helpers\Helper ;
use Illuminate\Http\Exceptions\HttpResponseException ;
use Illuminate\Contracts\Validation\Validator;

use App\Models\User ;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;




class LoginController extends Controller
{
    //

    public function login(Request $request){

        $user = User::where('email', $request->email)->first();
        $token = JWTAuth::fromUser($user);

        //var_dump($user,$request->password,$user->password);



        if ($user && Hash::check($request->password, $user->password))  {
            //dd($user);
             $ressoure = new UserResource($user);
            return response()->json([
                'success' => true,
                'message' => 'Valid user',
                'token' => $token,

            ], 201); 
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Failed to log in',
            ], 500);
                

        }



        
    }
}
