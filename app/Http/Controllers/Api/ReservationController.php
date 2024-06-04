<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Réservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'required|string|max:10',
            'email' => 'required|email',
            'telephone' => 'required|numeric|digits_between:10,15',
            'adresse' => 'required|string|max:255',
            'médecin_id' => 'required|exists:médecins,id',
            'departement_id' => 'required|exists:departements,id',
        ]);

        // Check if the date is in the past
        if (Carbon::parse($validatedData['date'])->isPast()) {
            return response()->json(['error' => 'Veuillez sélectionner une date future.'], 400);
        }

        // Check if the doctor already has 12 appointments on the selected date
        $appointmentCount = Réservation::where('médecin_id', $validatedData['médecin_id'])
            ->whereDate('date', $validatedData['date'])
            ->count();

        if ($appointmentCount >= 12) {
            return response()->json(['error' => 'Le médecin a atteint le nombre maximum de 12 rendez-vous pour cette date. Veuillez sélectionner une autre date.'], 400);
        }

        // Create the patient record
        $patient = Patient::create([
            'name' => $validatedData['name'],
            'prenom' => $validatedData['prenom'],
            'cin' => $validatedData['cin'],
            'email' => $validatedData['email'],
            'telephone' => $validatedData['telephone'],
            'adresse' => $validatedData['adresse'],
        ]);

        // Create the reservation record
        $reservation = Réservation::create([
            'date' => $validatedData['date'],
            'médecin_id' => $validatedData['médecin_id'],
            'patients' => $patient->id,
            'departement_id' => $validatedData['departement_id'],
        ]);

        return response()->json([
            'message' => 'Reservation and patient created successfully',
            'reservation' => $reservation,
            'patient' => $patient,
        ], 201);
    }
}
