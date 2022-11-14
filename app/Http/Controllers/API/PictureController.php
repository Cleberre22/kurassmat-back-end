<?php

namespace App\Http\Controllers\API;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'urlPicture' => 'required|image|mimes:jpg,jpeg,png,gif,svg',
            'namePicture' => 'required|max:100',
            'childs_id'
        ]);
        $image = $request->file('urlPicture');
        $input['urlPicture'] = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/thumbnail');
        $imgFile = Image::make($image->getRealPath());
        $imgFile->resize(1920, 1920, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $input['urlPicture']);
        $destinationPath = public_path('/uploads');
        $image->move($destinationPath, $input['urlPicture']);
        // return back()
        // 	->with('success','Image has successfully uploaded.')
        // 	->with('fileName',$input['urlPicture']);
        // dd($image);

        // On crée une nouvelle photo
        $image = Picture::create([
            'urlPicture' => $input['urlPicture'],
            'namePicture' => $request->namePicture,
            'childs_id' => $request->childs_id,
        ]);

        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($image, 201);
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
