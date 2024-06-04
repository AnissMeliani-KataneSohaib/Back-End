<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Réservation extends Model
{
    use HasFactory,HasApiTokens,Notifiable;

    protected $fillable=[
        'date','médecin_id','patients','departement_id'
    ];

}
