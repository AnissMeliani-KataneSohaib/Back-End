<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Réceptionniste;
use Illuminate\Http\Request;

class ReceptionnisteController extends Controller
{
    public function index() {

        $réceptionnistes = Réceptionniste::all();

        return response()->json($réceptionnistes, 200);
    }

    public function show($id) {

        $réceptionnistes = Réceptionniste::find($id);

        return response()->json($réceptionnistes, 200);
    }
    public function destroy($id) {
        $réceptionniste = Réceptionniste::find($id);
    
        if (!$réceptionniste) {
            return response()->json(['message' => 'Réceptionniste not found'], 404);
        }
    
        $réceptionniste->delete();
    
        return response()->json(['message' => 'Réceptionniste deleted successfully'], 200);
    }
    public function update(Request $request, $id) {
    $réceptionniste = Réceptionniste::find($id);
    $validate =$request->validate([
        'nom' => 'nullable|string|max:255',
        'prenom' => 'nullable|string|max:255',
        'email' => 'nullable|string|email',
        'telephone' => 'nullable|string|max:255',
        'role' => 'nullable|string',

    ]);

    $Check = [
        'nom' => $validate['nom'] ,
        'prenom' => $validate['prenom'],
        'email' => $validate['email'],
        'telephone' => $validate['telephone'],
        'role' => $validate['role'],
        
    ];

    $update = $réceptionniste->update($Check);
    if ($update) {
        return response()->json([
            'message' => 'Réceptionniste updated successfully',
            'data' => $réceptionniste
        ]);
    }else {
        return response()->json([
            'message' => 'Réceptionniste not updated'
        ]);
    }

    
}
}
