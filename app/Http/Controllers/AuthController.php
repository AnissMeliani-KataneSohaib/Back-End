<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Médecin;
use App\Models\Modérateur;
use App\Models\Réceptionniste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
   public function register(RegisterRequest $request)
   {
       $data = $request->validated();
   
     
       switch ($data['role']) {
           case 'médecin':
               $user = Médecin::create([
                   'nom' => $data['nom'],
                   'prenom' => $data['prenom'],
                   'email' => $data['email'],
                   'role' => $data['role'],
                   'telephone' => $data['telephone'],
                   'specialité' => $data['specialité'],
                   'departement_id' => $data['departement_id'],
                   'password' => Hash::make($data['password']),
               ]);
               break;
           case 'moderateur':
               $user = Modérateur::create([
                   'nom' => $data['nom'],
                   'prenom' => $data['prenom'],
                   'email' => $data['email'],
                   'role' => $data['role'],
                   'password' => Hash::make($data['password']),
               ]);
               break;
           case 'récepiosinniste':
               $user = Réceptionniste::create([
                   'nom' => $data['nom'],
                   'prenom' => $data['prenom'],
                   'email' => $data['email'],
                   'telephone' => $data['telephone'],
                   'role' => $data['role'],
                   'password' => Hash::make($data['password']),
               ]);
               break;
           default:
               return response()->json([
                   'message' => 'Invalid role specified.'
               ], 422);
       }
   
       // If user creation was successful
       if ($user) {
           $token = $user->createToken('auth_token')->plainTextToken;
           $cookie = cookie('token', $token, 60 * 24); // 1 day
           return response()->json([
               'user' => new UserResource($user),
           ])->withCookie($cookie)->setStatusCode(201, 'User created successfully');
       }
   
       // If user creation failed
       return response()->json([
           'message' => 'User registration failed.'
       ], 500);
   }
   

// login a user method
public function login(LoginRequest $request) {
    $data = $request->validated();

    // Search for user in all three tables
    $user = Médecin::where('email', $data['email'])->first();
    if (!$user) {
        $user = Réceptionniste::where('email', $data['email'])->first();
        if (!$user) {
            $user = Modérateur::where('email', $data['email'])->first();
        }
    }

    // If user not found or password doesn't match, return error
    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json([
            'message' => 'Email or password is incorrect!'
        ], 401);
    }

    // Generate token
    $token = $user->createToken('auth_token')->plainTextToken;

    // Set the appropriate route based on user role
    $route = '';
    switch ($user->role) {
        case 'médecin':
            $route = '/médecin';
            break;
        case 'moderateur':
            $route = '/moderateur';
            break;
        case 'récepiosinniste':
            $route = '/récepiosinniste';
            break;
        // Add more cases if needed for other roles
    }

    // Set the cookie and return response
    $cookie = cookie('token', $token, 60 * 24); // 1 day
    return response()->json([
        'user' => new UserResource($user),
    ])->withCookie($cookie)->setStatusCode(200, 'Login Successful')->header('Location', url($route)); // Corrected
}


    
    // get the authenticated user method
    public function user(Request $request) {
        return new UserResource($request->user());
    }
}