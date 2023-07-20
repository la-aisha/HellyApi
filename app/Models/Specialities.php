<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialities extends Model
{
    use HasFactory;
    protected $fillable = array('nom','description');
    public static $rules = array('nom'=>'required|min:3',
    'description'=>'required|min:3',
    );

    /**
     * Get all of the doctors for the Specialities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medecins(): HasMany
    {
        return $this->hasMany(Medecin::class, 'foreign_key', 'local_key');
    }

}
