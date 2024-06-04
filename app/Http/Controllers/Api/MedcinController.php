<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\Médecin;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Psy\Readline\Hoa\Console;

class MedcinController extends Controller
{
    public function index() {

        $medcins = Médecin::all();

        return response()->json(['medcins'=>$medcins], 200);
    }

    public function show($id) {

        $medcins = Médecin::find($id);

        return response()->json($medcins, 200);
    }

    public function store(Request $request) {
        // Validate the request data
        $validate = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email',
            'telephone' => 'required|string|max:255',
            'specialité' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'departement_id' => 'required', // Ensure department exists
        ]);
    
        // Fetch the department by its name
        $department = Departement::where('name', $request->departement)->first();
        $id = $department->id ;
        if (!$department) {
            return response()->json(['message' => 'The selected departement is invalid.'], 422);
        }

        $medcin = Médecin::create([
            'nom' => $validate['nom'],
            'prenom' => $validate['prenom'],
            'email' => $validate['email'],
            'telephone' => $validate['telephone'],
            'specialité' => $validate['specialité'],
            'role' => $validate['role'],
            'password' => Hash::make($validate['password']),
            'departement_id' => $id, 
        ]);
    
        return response()->json(['message' => 'Médecin created successfully', 'medcin' => $medcin], 201);
    }
    // public function show($id) {
    //     $medcin = Médecin::find($id);
    
    //     if (!$medcin) {
    //         return response()->json(['message' => 'Médecin not found'], 404);
    //     }
    
    //     return response()->json($medcin, 200);
    // }
    public function destroy($id) {
        $medcin = Médecin::find($id);
    
        if (!$medcin) {
            return response()->json(['message' => 'Médecin not found'], 404);
        }
    
        $medcin->delete();
    
        return response()->json(['message' => 'Médecin deleted successfully'], 200);
    }
    public function update(Request $request, $id) {
    $medcin = Médecin::find($id);
    $validate =$request->validate([
        'nom' => 'nullable|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'email' => 'nullable|string|email',
        'telephone' => 'nullable|string|max:255',
        'specialité' => 'nullable|string|max:255',
        'role' => 'nullable|string',

    ]);

    $Check = [
        'nom' => $validate['nom'] ,
        'prenom' => $validate['prenom'],
        'email' => $validate['email'],
        'telephone' => $validate['telephone'],
        'specialité' => $validate['specialité'],
        'role' => $validate['role'],
        
    ];

    $update = $medcin->update($Check);
    if ($update) {
        return response()->json([
            'message' => 'Médecin updated successfully',
            'data' => $medcin
        ]);
    }else {
        return response()->json([
            'message' => 'Médecin not updated'
        ]);
    }
    }
    public function search($departement_id){
        $medcins = Médecin::where('departement_id', $departement_id)->get();
        if($medcins->isEmpty()) {
            return response()->json([
                'message' => 'Aucun medecin n\'est disponible pour ce departement',
            ]);
        }else{
            return response()->json([
                'message' => 'Médecin found successfully',
                'medcins'=> $medcins
                , 200]);
        }
       
    }
    
    
    

}



