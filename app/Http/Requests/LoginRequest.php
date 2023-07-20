<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/*  */

class LoginRequest extends FormRequest
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
            'firstname'=>'required|min:3',
            'number'=>'required|min:9',
            'ddn'=>'required|min:3',
            'status'=>'required|min:1',
            'user_id'=>'required|integer:1',
            'speciality_id'=>'required|integer:1',
            'role_id'=>'required|integer:1'
        ];
    }
}
