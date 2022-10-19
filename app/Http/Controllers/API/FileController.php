<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère tous les fichiers
        $files = File::orderByDesc('created_at')->get();
        // On retourne les informations des utilisateurs en JSON
        return response()->json($files);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameFile' => 'required|max:100',
            'urlFile' => 'required|max:100',
            'type_files_id' => 'required',

        ]);

        // On crée un nouveau fichier
        $files = File::create([
            'nameFile' => $request->nameFile,
            'urlFile' => $request->urlFile,
            'type_files_id' => $request->type_files_id,
            'childs_id' => $request->childs_id,
            'users_id' => $request->users_id,
        ]);
        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($files, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
         // On retourne les informations d'un message de contact' en JSON
         return response()->json($file);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
       // On supprime le fichier
       $file->delete();
       // On retourne la réponse JSON
       return response()->json([
           'status' => 'Supprimé avec succès'
       ]);
    }
}
