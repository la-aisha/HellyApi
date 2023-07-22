<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


use App\Models\fichierMedecin;
use Illuminate\Database\Eloquent\Relations\Hasmany;


class Medecin extends Model
{
    use HasFactory;
    protected $fillable = array('firstname','lastname','email','address','number','ddn','status','user_id','speciality_id','hopital_id');
    public static $rules = array('firstname'=>'required|min:3',
    'lastname'=>'required|min:3',
    'number'=>'required|min:9',
    'email'=>'required|min:25',

    'address'=>'required|min:9',
    'ddn'=>'required|min:3',
    'status'=>'required|min:1',
    'user_id'=>'required|integer:1',
    'speciality_id'=>'required|integer:1',
    'hopital_id'=>'required|integer:1'



);
   /**
     * Get all of the fichierMedecin for the Hopital
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fichiers(): HasMany
    {
        return $this->hasMany(FichierMedecin::class);
    }
    /**
     * Get the speciality associated with the medecin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function speciality(): HasOne
    {
        return $this->hasOne(Speciality::class);
    }

    public function hopital(): HasOne
    {
        return $this->hasOne(Hopital::class);
    }

    /**
     * Get the user that owns the Medecin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
