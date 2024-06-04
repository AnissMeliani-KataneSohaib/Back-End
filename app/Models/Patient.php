<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable = ['id','name', 'cin','email', 'prenom', 'telephone', 'adresse','state'];
}
