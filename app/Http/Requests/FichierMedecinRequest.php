<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/* ------ */
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException ;

class FichierMedecinRequest extends FormRequest
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
            'file_name'=>'required|min:20',
            'file_path'=>'required|min:3',
            'status'=>'required|min:9',
            'medecin'=>'required|integer:1',
            'created_at'

        ];
    }
}
