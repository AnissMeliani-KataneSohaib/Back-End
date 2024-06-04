<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array {
        $data = [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => $this->role,
            'token' => $this->createToken('API Token')->plainTextToken
        ];
        switch ($this->role) {
            case 'médecin':
                $data['telephone'] = $this->telephone;
                $data['specialité'] = $this->specialité;
                break;
            case 'moderateur':
                break;
            case 'récepiosinniste':
                $data['telephone'] = $this->telephone;
                break;    
        }

        return $data;
    }
}