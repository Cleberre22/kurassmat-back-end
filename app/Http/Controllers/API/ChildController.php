<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère toute les fiches "enfant"
        $children = Child::orderBy('lastnameChild')->orderBy('lastnameChild')->get();

        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $children,
        ]);
    }

       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function childIndexAuth($id)
    {
        $children = DB::table('children')

        ->join('child_user', 'children.id', '=', 'child_user.child_id')
        
        ->join('users', 'users.id', '=', 'child_user.user_id')

        ->select('children.*', 'users.*', 'child_user.*')

        ->where('child_user.user_id', '=', $id)

        ->get();
       
        // On retourne les informations des utilisateurs en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $children,
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
        $validator = Validator::make($request->all(), [
            'firstnameChild' => 'required|max:100',
            'lastnameChild' => 'required|max:100',
            'birthDate' => 'required',
            'imageChild' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'users_id' => 'required',
        ]);

        $filename = "";
        if ($request->hasFile('imageChild')) {
            // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
            $filenameWithExt = $request->file('imageChild')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // On récupère l'extension du fichier, résultat $extension : ".jpg"
            $extension = $request->file('imageChild')->getClientOriginalExtension();
            // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore :"jeanmiche_20220422.jpg"
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
            $path = $request->file('imageChild')->storeAs('public/uploads', $filename);
        } else {
            $filename = Null;
        }

        // On crée une nouvelle fiche "enfant"
        $childs = Child::create([
            'firstnameChild' => $request->firstnameChild,
            'lastnameChild' => $request->lastnameChild,
            'birthDate' => $request->birthDate,
            'imageChild' => $filename,
            'users_id' => $request->users_id,
        ]);

        //Comment remplir une table pivot 
        //Je récupère mes Users/Employer dans le formulaire
        $users = $request->users_id;

        $users_id = explode(",", $users);

        //Et le boucle pour les rentrer dans la base de données
        for ($i = 0; $i < count($users_id); $i++) {
            $user = User::find($users_id[$i]);
            $childs->users()->attach($user);
        }

        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($childs, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function show(Child $child)
    {
        $child = DB::table('children')

            ->join('child_user', 'children.id', '=', 'child_user.child_id')
            ->join('users', 'users.id', '=', 'child_user.user_id')
            // ->join('day_summaries', 'children.id', '=', 'day_summaries.childs_id')
            // ->join('pictures', 'children.id', '=', 'pictures.childs_id')


            // ->join('child_person_to_contact', 'children.id', '=', 'child_person_to_contact.child_id')
            // ->join('person_to_contacts', 'person_to_contacts.id', '=', 'child_person_to_contact.person_to_contact_id')

            // ->select('children.', 'users.', 'child_user.', 'day_summaries.', 'person_to_contacts.')

            // ->select('children.', 'users.', 'child_user.', 'day_summaries.*', 'pictures.*')
            ->select('children.', 'users.', 'child_user.')

            ->select('children.id AS idChild', 'children.firstnameChild', 'children.lastnameChild', 'children.birthDate', 'children.imageChild', 'users.id', 'users.firstname', 'users.lastname', 'users.role', 'users.email', 'users.address', 'users.postalCode', 'users.city', 'users.phone', 'child_user.id')

            ->where('children.id', $child->id)

            ->get();

        // On retourne les informations d'une fiche "enfant" en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $child,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Child $child)
    {
        $this->validate($request, [
            'firstnameChild' => 'required|max:100',
            'lastnameChild' => 'required|max:100',
            'birthDate' => 'required',
        ]);

        // $filename = "";
        // if ($request->hasFile('imageChild')) {
        //     // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
        //     $filenameWithExt = $request->file('imageChild')->getClientOriginalName();
        //     $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // On récupère l'extension du fichier, résultat $extension : ".jpg"
        //     $extension = $request->file('imageChild')->getClientOriginalExtension();
        //     // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore :"jeanmiche_20220422.jpg"
        //     $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
        //     // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
        //     $path = $request->file('imageChild')->storeAs('public/uploads', $filename);
        // } else {
        //     $filename = Null;
        // }

        // On modifie la fiche "enfant"
        $child->update([
            'firstnameChild' => $request->firstnameChild,
            'lastnameChild' => $request->lastnameChild,
            'birthDate' => $request->birthDate,
            // 'imageChild' => $filename,
        ]);

        // On retourne les informations du sondage modifié en JSON
        return response()->json([
            'status' => 'Fiche "enfant" mise à jour avec succès'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Child  $childImage
     * @return \Illuminate\Http\Response
     */
    public function childUpdateImage(Request $request, Child $childImage)
    {
        // dd($childImage);
        $this->validate($request, [
            'lastnameChild' => 'required|max:100',
            // 'imageChild' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ]);

        // $filename = "";
        // if ($request->hasFile('imageChild')) {
        //     // On récupère le nom du fichier avec son extension, résultat $filenameWithExt : "jeanmiche.jpg"
        //     $filenameWithExt = $request->file('imageChild')->getClientOriginalName();
        //     $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //     // On récupère l'extension du fichier, résultat $extension : ".jpg"
        //     $extension = $request->file('imageChild')->getClientOriginalExtension();
        //     // On créer un nouveau fichier avec le nom + une date + l'extension, résultat $fileNameToStore :"jeanmiche_20220422.jpg"
        //     $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
        //     // On enregistre le fichier à la racine /storage/app/public/uploads, ici la méthode storeAs défini déjà le chemin /storage/app
        //     $path = $request->file('imageChild')->storeAs('public/uploads', $filename);
        // }

        // On modifie la fiche "enfant"
        $childImage->childUpdateImage([
            'lastnameChild' => $request->lastnameChild,
            // 'imageChild' => $filename,
        ]);

        // On retourne les informations du sondage modifié en JSON
        return response()->json([
            'status' => 'Photo "enfant" mise à jour avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Child  $child
     * @return \Illuminate\Http\Response
     */
    public function destroy(Child $child)
    {
        // On supprime la fiche "enfant"
        $child->delete();
        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Fiche "enfant" supprimée avec succès'
        ]);
    }
}
