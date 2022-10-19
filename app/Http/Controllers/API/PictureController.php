<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
               // On récupère tous les photos
               $pictures = Picture::orderBy('created_at')->get();

               // On retourne les informations des utilisateurs en JSON
               return response()->json([
                   'status' => 'Success',
                   'data' => $pictures,
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
            'namePicture' => 'required|max:100',
            'urlPicture' => 'required|max:100',
            'childs_id' => 'required',
        ]);

        // On crée une nouvelle photo
        $pictures = Picture::create([
            'namePicture' => $request->namePicture,
            'urlPicture' => $request->urlPicture,
            'childs_id' => $request->childs_id,
        ]);
        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($pictures, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Picture $picture)
    {
         // On retourne les informations d'un type de fichier en JSON
         return response()->json([
            'status' => 'Success',
            'data' => $picture,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
