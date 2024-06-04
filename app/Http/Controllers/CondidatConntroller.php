<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Condidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
class CondidatConntroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $condidats = Condidat::select('id' ,'cin', 'nom', 'prenom', 'email', 'telephone', 'cv')->get();

        return response()->json([
            'condidats' => $condidats
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Condidat $condidat)
    {
        // This function can be used to provide an empty form for creating a new Condidat,
        // but currently doesn't return any specific data. You can modify it to return
        // relevant information for the frontend form.
        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'cin' => 'required',
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required|email',// Ensure valid email format
                'telephone' => 'required' ,
                'cv' => 'nullable' // Optional CV, must be PDF
            ]);

            $uploadedCv = $request->file('cv');
            if ($uploadedCv) {
                $cvName = Str::random() . '.' . $uploadedCv->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/cv', $uploadedCv, $cvName);
                $validatedData['cv'] = $cvName;
            }

            Condidat::create($validatedData);

            return response()->json([
                'message' => 'La demande a été déposée'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Implementations for show, edit, update, and destroy functions are missing

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function show( $id){
       $condidat=Condidat::find($id);
       return response()->json([$condidat,200]);
     }

    public function showCv($cvPath)
{
    $filePath = storage_path('app/public/product/cv/' . $cvPath);

    if (!file_exists($filePath)) {
        return response()->json(['message' => 'CV not found'], 404);
    }

    return response()->file($filePath);
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // ... (function implementation)
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ... (function implementation)
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Condidat  $condidat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $condidat = Condidat::findOrFail($id); // Find the condidat by ID, or fail with a 404 error
            $condidat->delete(); // Call delete on the model instance

            return response()->json(['message' => 'Condidat supprimé avec succès'], 200);
        } catch (\Exception $e) {
            // Handle the error
            return response()->json(['error' => 'Une erreur s\'est produite lors de la suppression du Condidat'], 500);
        }
    }
    }
