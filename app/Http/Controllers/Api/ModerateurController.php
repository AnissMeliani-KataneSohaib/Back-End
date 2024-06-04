<?php

namespace App\Http\Controllers\Api;
use App\Models\Modérateur;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModerateurController extends Controller
{
    public function index() {

        $medcins = Modérateur::all();

        return response()->json($medcins, 200);
    }

    public function show($id) {

        $moderateurs = Modérateur::find($id);

        return response()->json($moderateurs, 200);
    }
    public function destroy($id) {
        $moderateur = Modérateur::find($id);
    
        if (!$moderateur) {
            return response()->json(['message' => 'moderateur not found'], 404);
        }
    
        $moderateur->delete();
    
        return response()->json(['message' => 'moderateur deleted successfully'], 200);
    }
    public function update(Request $request, $id) {
        $moderateur = Modérateur::find($id);
        $validate =$request->validate([
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'nullable|string|email',
            'role' => 'nullable|string',
        ]);
    
        $Check = [
            'nom' => $validate['nom'],
            'prenom' => $validate['prenom'],
            'email' => $validate['email'],
            'role' => $validate['role'],
        ];
    
        $update = $moderateur->update($Check);
        if ($update) {
            return response()->json([
                'message' => 'moderateur updated successfully',
                'data' => $moderateur
            ]);
        } else {
            return response()->json([
                'message' => 'moderateur not updated'
            ]);
        }
    }
}
