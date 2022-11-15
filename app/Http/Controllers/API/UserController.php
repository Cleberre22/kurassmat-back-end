<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $users = User::orderByDesc('created_at')->get();
        // On retourne les informations des utilisateurs en JSON
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // On retourne les informations des utilisateurs en JSON
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // dd($user);
        $this->validate($request, [
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'address' => 'required|string|max:200',
            'postalCode' => 'required|string|max:5',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:100',
            'imageUser' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $filename = "";
        if ($request->hasFile('imageUser')) {
            // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
            $filenameWithExt = $request->file('imageUser')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // On récupère l'extension du fichier, résultat $extension : ".jpg"
            $extension = $request->file('imageUser')->getClientOriginalExtension();
            // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore :"jeanmiche_20220422.jpg"
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
            $path = $request->file('imageUser')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }

        // On modifie l'utilisateur
        $user->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'address' => $request->address,
            'postalCode' => $request->postalCode,
            'city' => $request->city,
            'phone' => $request->phone,  
            'imageUser' => $filename,
        ]);
        // On retourne les informations du sondage modifié en JSON
        return response()->json([
            'status' => 'Profil mis à jour avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // On supprime le message de contact
        $user->delete();
        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Profil supprimé avec succès'
        ]);
    }
}
