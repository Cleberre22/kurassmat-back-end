<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PersonToContact;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PersonToContact  $personToContact
     * @return \Illuminate\Http\Response
     */
    public function show(PersonToContact $personToContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PersonToContact  $personToContact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PersonToContact $personToContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PersonToContact  $personToContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonToContact $personToContact)
    {
        //
    }
}
