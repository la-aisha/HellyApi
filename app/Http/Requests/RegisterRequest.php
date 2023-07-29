<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/* -------- */
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException ;
use Illuminate\Support\Facades\Hash;


class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
        'lastname'=>'required|min:',
        'firstaname'=>'required|min:3',
        'number'=>'required|min:9',
        'address'=>'required|min:9',
        'email'=>'required|min:9',


        'ddn'=>'required|min:3',
        'speciality_id'=>'required|integer:1',
        'hopital_id'=>'required|integer:1'
        ];
    }


    public function failedvalidation(){
        throw new HttResponceException(
            $response()->json([
                'success' => 'False',
                'message' => 'Validation error',
                'data' => $validator->errors()->all()
                ,
            ],422)
        ) ;
    }
}
