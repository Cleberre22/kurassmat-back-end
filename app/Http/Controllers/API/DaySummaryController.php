<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DaySummary;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DaySummary  $daySummary
     * @return \Illuminate\Http\Response
     */
    public function show(DaySummary $daySummary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DaySummary  $daySummary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DaySummary $daySummary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DaySummary  $daySummary
     * @return \Illuminate\Http\Response
     */
    public function destroy(DaySummary $daySummary)
    {
        //
    }
}
