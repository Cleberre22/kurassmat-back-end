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
        $children = Child::orderByDesc('created_at')->get();

        $children = DB::table('children')
            ->join('child_user', 'children.id', '=', 'child_user.child_id')
            ->join('users', 'users.id', '=', 'child_user.user_id')

            ->join('child_person_to_contact', 'children.id', '=', 'child_person_to_contact.child_id')
            ->join('person_to_contacts', 'person_to_contacts.id', '=', 'child_person_to_contact.person_to_contact_id')

            ->select('children.*', 'users.*', 'person_to_contacts.*')
            ->get()
            ->toArray();


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

        for ($i = 0; $i < count($users); $i++) {
            $user = User::find($users[$i]);
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

            ->join('child_person_to_contact', 'children.id', '=', 'child_person_to_contact.child_id')
            ->join('person_to_contacts', 'person_to_contacts.id', '=', 'child_person_to_contact.person_to_contact_id')
            

            ->select('children.*', 'users.*', 'person_to_contacts.*')
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
        $users = $request->users_id;

        for ($i = 0; $i < count($users); $i++) {
            $user = User::find($users[$i]);
            $child->users()->attach($user);
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
