<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Departement;
use Illuminate\Notifications\Notifiable;

class Médecin extends Model
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable=[
     'nom','email','prenom','telephone','specialité','role','password','departement_id'
    ];
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
}
