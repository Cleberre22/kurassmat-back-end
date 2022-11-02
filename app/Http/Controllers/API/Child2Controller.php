<?php

namespace App\Http\Controllers\API;

use App\Models\Child;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
        $children = Child::orderBy('lastnameChild')->get();

         // $child = DB::table('children')

            // ->join('child_user', 'children.id', '=', 'child_user.child_id')
            // ->join('users', 'users.id', '=', 'child_user.user_id')

            // ->join('child_person_to_contact', 'children.id', '=', 'child_person_to_contact.child_id')
            // ->join('person_to_contacts', 'person_to_contacts.id', '=', 'child_person_to_contact.person_to_contact_id')


            // ->select('children.*', 'users.*', 'person_to_contacts.*')

            // ->select('children.*', 'users.*', 'child_user.*')

            // ->select('children.id AS Enfant Identifiant', 'children.firstnameChild AS Enfant Prénom', 'children.lastnameChild AS Enfant Nom', 'children.birthDate AS Enfant Date de naissance', 'children.imageChild AS Enfant Avatar', 'users.id AS Utilisateur Identifiant','users.firstname AS Utilisateur Prénom','users.lastname AS Utilisateur Nom','users.role AS Utilisateur Role','users.email AS Utilisateur Email','users.address AS Utilisateur Adresse','users.postalCode AS Utilisateur Code Postal','users.city AS Utilisateur Ville','users.phone AS Utilisateur Téléphone', 'child_user.id AS Identifiant en commun Table Pivot')
            
            // ->where('children.id', $child->id)

            // ->get();
            // ->toArray();

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
        $request->validate([
            'firstnameChild' => 'required|max:100',
            'lastnameChild' => 'required|max:100',
            'birthDate' => 'required',
            'imageChild' => 'required|max:100',
            'users_id' => 'required',
        ]);

        // On crée une nouvelle fiche "enfant"
        $childs = Child::create([
            'firstnameChild' => $request->firstnameChild,
            'lastnameChild' => $request->lastnameChild,
            'birthDate' => $request->birthDate,
            'imageChild' => $request->imageChild,
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
        // $child = DB::table('children')

            // ->join('child_user', 'children.id', '=', 'child_user.child_id')
            // ->join('users', 'users.id', '=', 'child_user.user_id')

            // ->join('child_person_to_contact', 'children.id', '=', 'child_person_to_contact.child_id')
            // ->join('person_to_contacts', 'person_to_contacts.id', '=', 'child_person_to_contact.person_to_contact_id')


            // ->select('children.*', 'users.*', 'person_to_contacts.*')

            // ->select('children.*', 'users.*', 'child_user.*')

            // ->select('children.id AS Enfant Identifiant', 'children.firstnameChild AS Enfant Prénom', 'children.lastnameChild AS Enfant Nom', 'children.birthDate AS Enfant Date de naissance', 'children.imageChild AS Enfant Avatar', 'users.id AS Utilisateur Identifiant','users.firstname AS Utilisateur Prénom','users.lastname AS Utilisateur Nom','users.role AS Utilisateur Role','users.email AS Utilisateur Email','users.address AS Utilisateur Adresse','users.postalCode AS Utilisateur Code Postal','users.city AS Utilisateur Ville','users.phone AS Utilisateur Téléphone', 'child_user.id AS Identifiant en commun Table Pivot')
            
            // ->where('children.id', $child->id)

            // ->get();

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
            'imageChild' => 'required|max:100',
            'users_id' => 'required',
        ]);
        // On modifie la fiche "enfant"
        $child->update([
            'firstnameChild' => $request->firstnameChild,
            'lastnameChild' => $request->lastnameChild,
            'birthDate' => $request->birthDate,
            'imageChild' => $request->imageChild,
            'users_id' => $request->users_id,
        ]);

        //Comment remplir une table pivot 
        //Je récupère mes Users/Employer dans le formulaire
        // Array à fournir pour la méthode sync
        $updateTabId = array();
        // Update user pivot
        $user = $request->users_id;
        if (!empty($user)) {
            for ($i = 0; $i < count($user); $i++) {
                $users = User::find($user[$i]);
                array_push($updateTabId, $users->id);
            }
            $child->users()->sync($updateTabId);
        }

        // On retourne les informations du sondage modifié en JSON
        return response()->json([
            'status' => 'Fiche "enfant" mise à jour avec succès'
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
