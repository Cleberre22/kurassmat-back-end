<?php

namespace App\Http\Controllers\API;

use App\Models\DaySummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DaySummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // On récupère tous les récapitulatifs de journée
         $daySummarys = DaySummary::orderByDesc('created_at')->get();
         // On retourne les informations des utilisateurs en JSON
         return response()->json($daySummarys);
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
            'contentDaySummary' => 'required',
            'childs_id' => 'required',
        ]);

        // On crée un nouveau récapitulatif de journée
        $daySummarys = DaySummary::create([
            'contentDaySummary' => $request->contentDaySummary,
            'childs_id' => $request->childs_id,
            'users_id' => $request->users_id,
        ]);
        // On retourne les informations du nouveau message de contact en JSON
        return response()->json($daySummarys, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DaySummary  $daySummary
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $daySummary = DB::table('day_summaries')
        ->get()
        ->where("id", $id)
        ->toArray();

         // On retourne les informations d'un message de contact' en JSON
         return response()->json($daySummary);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DaySummary  $daySummary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $daySummary = DB::table('day_summaries')
        ->where("id", $id)
        ->update([
            'contentDaySummary' => $request->contentDaySummary,
            'childs_id' => $request->childs_id,
            'users_id' => $request->users_id,
        ]);

        // On retourne les informations du type de fichier modifié en JSON
        return response()->json([
            'status' => 'Récapitulatif de journée mis à jour avec succès'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DaySummary  $daySummary
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // On supprime le récapitulatif de journée
         $daySummary = DB::table('day_summaries')
         ->where("id", $id)
         ->delete();
 
         // On retourne la réponse JSON
         return response()->json([
             'status' => 'Récapitulatif de journée supprimé avec succès'
         ]);
    }
}
