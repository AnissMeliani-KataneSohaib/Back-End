<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index() {

        $departements = Departement::all();
       
        return response()->json([
            'departements'=>$departements,
        ], 200);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departements',
        ]);
    
        $departement = Departement::create($validatedData);
        return response()->json(['message' => 'Department created successfully', 'departement' => $departement], 201);
    }
    


    public function show($id) {

        $departements = Departement::find($id);

        return response()->json($departements, 200);
    }
    public function destroy($id) {
        $departement = Departement::find($id);
    
        if (!$departement) {
            return response()->json(['message' => 'departement not found'], 404);
        }
    
        $departement->delete();
    
        return response()->json(['message' => 'departement deleted successfully'], 200);
    }
    public function update(Request $request, $id) {
        $medcin = Departement::find($id);
        $validate =$request->validate([
            'name' => 'nullable|string|max:255|unique:departements',
        ]);
    
        $Check = [
        'name' => $validate['name'] ,
            
];
    
        $update = $medcin->update($Check);
        if ($update) {
            return response()->json([
                'message' => 'departement updated successfully',
                'data' => $medcin
            ]);
        }else {
            return response()->json([
                'message' => 'departement not updated'
            ]);
        }
    
        
    }
    
}
