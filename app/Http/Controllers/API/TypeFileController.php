<?php

namespace App\Http\Controllers\API;

use App\Models\TypeFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TypeFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère tous les types de fichier
        $typeFiles = TypeFile::orderBy('nameTypeFile')->get();

        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $typeFiles,
        ]);
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
            'nameTypeFile' => 'required|max:100',
        ]);

        // On crée un nouveau type de fichier
        $typeFiles = TypeFile::create([
            'nameTypeFile' => $request->nameTypeFile,
        ]);
        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($typeFiles, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeFile  $typeFile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $typeFile = DB::table('type_files')
            ->get()
            ->where("id", $id)
            ->toArray();

         // On retourne les informations d'un type de fichier en JSON
         return response()->json([
            'status' => 'Success',
            'data' => $typeFile,
        ]);
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeFile  $typeFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $typeFile = DB::table('type_files')
        ->where("id", $id)
        ->update([
            'nameTypeFile' => $request->nameTypeFile,
        ]);
       

        // On retourne les informations du type de fichier modifié en JSON
        return response()->json([
            'status' => 'Type de fichier mis à jour avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeFile  $typeFile
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        // On supprime le type de fichier
        $typeFile = DB::table('type_files')
        ->where("id", $id)
        ->delete();

        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Type de fichier supprimé avec succès'
        ]);
    }
}
