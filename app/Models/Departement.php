<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Departement extends Model
{
    use HasFactory,HasApiTokens,Notifiable;

    protected $fillable=[
     'name'
    ];
    public function médecins()
    {
        return $this->hasMany(Médecin::class);
    }
}
