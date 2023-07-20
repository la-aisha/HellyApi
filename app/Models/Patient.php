<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    use HasFactory;
    protected $fillable = array('firstname','lastname','address','number','ddn','status','user_id','allergy_id');
    public static $rules = array('firstname'=>'required|min:3',
    'lastname'=>'required|min:3',
    'address'=>'required|min:3',

    'number'=>'required|min:9',
    'ddn'=>'required|min:3',
    'status'=>'required|min:1',
    'user_id'=>'required|integer:1',
    'allergy_id'=>'required|integer:1',

    



    );


   /**
    * The roles that belong to the Patient
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function allergies(): MorphToMany
    {
        return $this->morphToMany(Allergies::class);
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
