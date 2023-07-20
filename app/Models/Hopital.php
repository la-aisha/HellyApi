<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Hopital extends Model
{
    use HasFactory;
    protected $fillable = array('hopital_id', 'hopital_name', 'number', 'email','link','description','status');
    public static $rules = array('hopital_name'=>'required|min:5',
    'description'=>'required|min:50',
    'number'=>'required|min:9',
    'email'=>'required|min:3',
    'link'=>'required|min:3',
    'description'=>'required|min:200',
    'status'=>'required|min:1'

    );

    /**
     * Get all of the hopital for the hospital
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medecins(): HasOne
    {
        return $this-hasOne(Hopital::class);
    }
 

}
