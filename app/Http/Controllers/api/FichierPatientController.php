<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Patient;
use App\Models\FichierPatient;
use App\Http\Resources\FichierPatientResource;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile; // Import UploadedFile class
use Illuminate\Support\Str;


class FichierPatientController extends Controller
{
    public function createFichier(UploadedFile $file, int $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        // Generate a unique ID
        $uniqueId = Str::uuid()->toString();
    
        // Get the original filename
        $originalFileName = $file->getClientOriginalName();
        

        // Prepend the unique ID to the filename
        $fileNameWithUniqueId = $uniqueId . '_' . $originalFileName;

        // Store the file with the modified filename in the 'documents' disk
        $path = $file->storeAs('documentsPatient', $fileNameWithUniqueId, 'documents');

        $fichierPatient = FichierPatient::create([
            'file_name' => $originalFileName,
            'file_path' => $path,
            'patient_id' => $patientId,
            'created_at' => now(),
        ]);

        //STOCK FILE OF patient

        $patient->fichiers()->save($fichierPatient);
        

        return new FichierPatientResource($fichierPatient);
    }
}
