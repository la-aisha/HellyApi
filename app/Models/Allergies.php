<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;



class Allergies extends Model
{
    use HasFactory;
    protected $fillable = array('nom','description');
    public static $rules = array('nom'=>'required|min:3',
    'description'=>'required|min:200',
    );


   /**
    * The patients that belong to the Allergies
    *
    * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
    */
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'patient_allergies');
    }
}
