<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Patient;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class FichierPatient extends Model
{
    use HasFactory;
    protected $fillable = array('patient_id', 'file_name', 'file_path', 'created_at','status');
    public static $rules = array('patient_id'=>'required|min:5',
    'file_name'=>'required|min:30',
    'file_path'=>'required|min:9',
    'status'=>'required|min:1',
    'created_at'=>'required|min:20');


    /**
     * Get the medecin that owns the FichierMedecin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

}
