<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Medecin;
use App\Models\FichierMedecin;
use App\Http\Resources\FichierMedecinResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile; // Import UploadedFile class
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class FichierMedecinController extends Controller
{
    public function createFichier(UploadedFile $file, int $medecinId)
    {
        $medecin = Medecin::findOrFail($medecinId);

        // Generate a unique ID
        $uniqueId = Str::uuid()->toString();
    
        // Get the original filename
        $originalFileName = $file->getClientOriginalName();

        // Prepend the unique ID to the filename
        $fileNameWithUniqueId = $uniqueId . '_' . $originalFileName;

        // Store the file with the modified filename in the 'documents' disk
        $path = $file->storeAs('documents', $fileNameWithUniqueId, 'public');
        //Storage::disk('documents')->put($fileNameWithUniqueId, file_get_contents($file));


        $fichierMedecin = FichierMedecin::create([
            'file_name' => $originalFileName,
            'file_path' => $path,
            'medecin_id' => $medecinId,
            'created_at' => now(),
        ]);

        $medecin->fichiers()->save($fichierMedecin);
        $med =new FichierMedecinResource($fichierMedecin);
        dd($file);
        //Log::debug($file); // Check the logs in storage/logs/laravel.log


    }
}