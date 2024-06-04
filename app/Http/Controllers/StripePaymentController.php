<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Réservation;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Webhook;


class StripePaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        // Set Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Basic validation
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        try {
            // Create Stripe session
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' =>  $validatedData['name'],
                            'description' => $validatedData['description'],
                        ],
                        'unit_amount' => intval($validatedData['price'] * 100), // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => env('FRONTEND_URL') . '/appointment',
                'cancel_url' => env('FRONTEND_URL') . '/appointment',
            ]);

            return response()->json(['id' => $checkout_session->id]);
        } catch (ApiErrorException $e) {
            // Handle Stripe API error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function handleWebhook(Request $request)
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the checkout.session.completed event
        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;

            // Retrieve patient and reservation data from session metadata or other sources
            $patientData = [
                'name' => $session->metadata->name,
                'prenom' => $session->metadata->prenom,
                'cin' => $session->metadata->cin,
                'email' => $session->metadata->email,
                'telephone' => $session->metadata->telephone,
                'adresse' => $session->metadata->adresse,
                'departement_id' => $session->metadata->departement_id,
            ];

            $patient = Patient::create($patientData);

            $reservationData = [
                'date' => $session->metadata->date,
                'médecin_id' => $session->metadata->médecin_id,
                'patients' => $patient->id,
                'departement_id' => $session->metadata->departement_id,
            ];

            $reservation = Réservation::create($reservationData);

            // Log success or further actions
        }

        return response()->json(['status' => 'success'], 200);
    }
}