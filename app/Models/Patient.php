<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\fichierPatient;
use Illuminate\Database\Eloquent\Relations\Hasmany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



class Patient extends Model
{
    use HasFactory;
    protected $fillable = array('firstname','lastname','address','number','ddn','status', 'email','user_id','allergy_id');
    public static $rules = array('firstname'=>'required|min:3',
    'lastname'=>'required|min:3',
    'address'=>'required|min:3',
    'email'=>'required|min:3',
    'number'=>'required|min:9',
    'ddn'=>'required|min:3',
    'status'=>'required|min:1',
    'user_id'=>'required',
    'allergy_id'=>'required',

    



    );

 /**
     * Get all of the fichierMedecin for the Hopital
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fichiers(): HasMany
    {
        return $this->hasMany(FichierPatient::class);
    }
   /**
    * The roles that belong to the Patient
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function allergies(): BelongsToMany
    {
        return $this->belongsToMany(Allergies::class, 'patient_allergies');
    }
    /**
     * Get the user that owns the Patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
