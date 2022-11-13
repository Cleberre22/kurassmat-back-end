<?php

namespace App\Http\Controllers\API;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function PictureindexChild($id)
    {
        // On récupère tous les récapitulatifs de journée
        $pictures = DB::table('pictures')

            ->join('children', 'children.id', '=', 'pictures.childs_id')

            ->select('children.*', 'pictures.*')

            ->where('pictures.childs_id', '=', $id)

            ->orderByDesc('pictures.created_at')

            ->get();

        // On retourne les informations des utilisateurs en JSON
        return response()->json($pictures);
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
            'urlPicture' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'namePicture' => 'required|max:100',
            'childs_id' => 'required'
        ]);

        $filename = "";
        if ($request->hasFile('urlPicture')) {
            // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
            $filenameWithExt = $request->file('urlPicture')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // On récupère l'extension du fichier, résultat $extension : ".jpg"
            $extension = $request->file('urlPicture')->getClientOriginalExtension();
            // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore :"jeanmiche_20220422.jpg"
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;


            $filename = $request->file('urlPicture');
            $filename = Picture::make($filename->path());
            $filename->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($request.'public/uploads'.$filename);



            // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
        //     $path = $request->file('urlPicture')->storeAs('public/uploads', $filename);
        // } else {
        //     $filename = Null;
        // }

        // On crée une nouvelle photo
        $pictures = Picture::create([
            
            'urlPicture' => $filename,
            'namePicture' => $request->namePicture,
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
          // On supprime la photo
       $picture->delete();
       // On retourne la réponse JSON
       return response()->json([
           'status' => 'Supprimé avec succès'
       ]);
    }
}
