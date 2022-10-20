<?php

namespace App\Http\Controllers\API;

use App\Models\Child;
use Illuminate\Http\Request;
use App\Models\PersonToContact;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PersonToContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // On récupère toutes les personnes a contacter
         $personToContacts = PersonToContact::orderByDesc('lastnamePerson')->get();
         // On retourne les informations des utilisateurs en JSON
         return response()->json($personToContacts);
    }

    /**d
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstnamePerson' => 'required|max:100',
            'lastnamePerson' => 'required|max:100',
            'addressPerson' => 'required',
            'phonePerson' => 'required|max:100',
            'child_id' => 'required',
        ]);

        // On crée une nouvelle personne a prévenir
        $personToContacts = PersonToContact::create([
            'firstnamePerson' => $request->firstnamePerson,
            'lastnamePerson' => $request->lastnamePerson,
            'addressPerson' => $request->addressPerson,
            'phonePerson' => $request->phonePerson,
            'childs_id' => $request->childs_id,
        ]);

        //Comment remplir une table pivot 
        //Je récupère mes fiches "enfants" dans le formulaire
        $children = $request->child_id;

        for ($i = 0; $i < count($children); $i++) {
            $child = Child::find($children[$i]);
            $personToContacts->children()->attach($child);
        }

        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($personToContacts, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PersonToContact  $personToContact
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personToContact = DB::table('person_to_contacts')
        ->get()
        ->where("id", $id)
        ->toArray();

         // On retourne les informations d'une personne a prévenir en JSON
         return response()->json([

            'status' => 'Success',
            'data' => $personToContact,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PersonToContact  $personToContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $personToContact = DB::table('type_files')
        ->where("id", $id)
        ->update([
            'firstnamePerson' => $request->firstnamePerson,
            'lastnamePerson' => $request->lastnamePerson,
            'addressPerson' => $request->addressPerson,
            'phonePerson' => $request->phonePerson,
        ]);
       

        // On retourne les informations de la personne a prévenir modifié en JSON
        return response()->json([
            'status' => 'Personne a prévenir mise à jour avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonToContact  $personToContact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // On supprime la personne a prévenir
        $personToContact = DB::table('person_to_contacts')
        ->where("id", $id)
        ->delete();

        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Personne a prévenir supprimée avec succès'
        ]);
    }
}
