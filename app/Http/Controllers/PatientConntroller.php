<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientConntroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
       return  Patient::select('id' ,'name','prenom','cin','email','telephone','adresse','state')->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(patient $patient)
    {
        //
        return response()->json([
            'product' => $patient
        ]);
    }

    public function ajoutetat(patient $patient, Request $request){

        $request->validate([
        'etat' => 'required',]);

        $patient->update([
            'etat_de_santé' => $request->input('etat'),
        ]);
    
        return response()->json([
            'message' => 'état_de_santé a ete ajouter'
        ],422);
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
        $request->validate([
            'name' => 'required',
            'prenom' => 'required',
            'cin' => 'required',
            'email'=>'required',
            'telephone'=>'required',
            'adresse'=>'required',
        ],
        [
            'name.required' => 'Le nom est obligatoire',
        ]);
        patient::create($request->post());
        return response()->json([
            'message' => 'Product created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, patient $patient)
{
    // Recherchez le patient avec l'ID spécifié
    $patient = $patient->findOrFail($id);

    // Retournez les données du patient sous forme de réponse JSON
    return response()->json([
        'patient' => $patient
    ]);
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $etat = Patient::find($id);
        $validate =$request->validate([
            'state' => 'nullable|string|max:255',
    
        ]);
    
        $Check = [
            'state' => $validate['state'] ,
       
            
        ];
    
        $update = $etat->update($Check);
        if ($update) {
            return response()->json([
                'message' => 'Etat updated successfully',
                'data' => $etat
            ]);
        }else {
            return response()->json([
                'message' => 'Etat not updated'
            ]);
        }
        }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(patient $patient)
    {
        //
        $patient->delete();
        return response()->json([
            'message' => 'patient deleted successfully'
        ]);
    }
}