<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère tous les messages de contact
        $contacts = Contact::orderByDesc('created_at')->get();
        // On retourne les informations des utilisateurs en JSON
        return response()->json($contacts);
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
            'firstnameContact' => 'required|max:100',
            'lastnameContact' => 'required|max:100',
            'emailContact' => 'required|max:100',
            'object' => 'required|max:100',
            'message' => 'required',
        ]);

        // On crée un nouvel message de contact
        $contacts = Contact::create([
            'firstnameContact' => $request->firstnameContact,
            'lastnameContact' => $request->lastnameContact,
            'emailContact' => $request->emailContact,
            'object' => $request->object,
            'message' => $request->message,
            'users_id' => $request->users_id,
        ]);
        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($contacts, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        // On retourne les informations d'un message de contact' en JSON
        return response()->json($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        // On supprime le message de contact
        $contact->delete();
        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimé avec succès'
        ]);
    }
}
