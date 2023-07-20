<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergies extends Model
{
    use HasFactory;
    protected $fillable = array('nom','description');
    public static $rules = array('nom'=>'required|min:3',
    'description'=>'required|min:3',
    );


   /**
    * The patients that belong to the Allergies
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function patients(): MorphToMany
    {
        return $this->morphToMany(Patient::class);
    }
}
