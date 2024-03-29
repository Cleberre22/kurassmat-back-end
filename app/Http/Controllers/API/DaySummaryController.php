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
        $daySummarys = DB::table('day_summaries')
            ->join('children', 'children.id', '=', 'day_summaries.childs_id')

            ->join('users', 'users.id', '=', 'day_summaries.users_id')

            ->select('children.id AS idChild', 'children.firstnameChild', 'children.lastnameChild', 'children.birthDate', 'children.imageChild', 'day_summaries.id', 'day_summaries.contentDaySummary', 'day_summaries.created_at', 'users.id AS idUser', 'users.firstname', 'users.lastname')
            
            ->orderByDesc('day_summaries.created_at')

            ->get();

        // On retourne les informations des utilisateurs en JSON
        return response()->json($daySummarys);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SummaryindexChild($id)
    {
        // On récupère tous les récapitulatifs de journée
        $daySummarys = DB::table('day_summaries')

            ->join('children', 'children.id', '=', 'day_summaries.childs_id')

            ->join('users', 'users.id', '=', 'day_summaries.users_id')

            ->select('children.*', 'users.*', 'day_summaries.*')

            ->where('day_summaries.childs_id', '=', $id)

            ->orderByDesc('day_summaries.created_at')

            ->get();

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
        return response()->json($daySummarys, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DaySummary  $daySummary
     * @return \Illuminate\Http\Response
     */
    public function show(DaySummary $daySummary)
    {
        $daySummary = DB::table('day_summaries')

            ->join('children', 'day_summaries.id', '=', 'children.day_summaries_id')

            ->join('day_summaries', 'day_summaries.id', '=', 'children.day_summaries.id')

            ->select('day_summaries.*', 'children.*')

            ->select('children.id AS idChild', 'children.firstnameChild', 'children.lastnameChild', 'children.birthDate', 'children.imageChild', 'day_summaries.id', 'day_summaries.contentDaySummary', 'day_summaries.created_at')

            ->where('day_summaries.id', $daySummary->id)

            ->get();

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
