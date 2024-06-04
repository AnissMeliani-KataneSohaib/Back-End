<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:réceptionnistes|unique:modérateurs|unique:médecins',
            'telephone' => 'required_if:role,médecin,récepiosinniste|numeric|min:10|',
            'departement_id' => 'required_if:role,médecin|string|max:255',
            'specialité' => 'required_if:role,médecin|string|max:255',
            'role' => 'required|string|in:médecin,moderateur,récepiosinniste',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
