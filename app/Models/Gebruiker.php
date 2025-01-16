<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Gebruiker extends Model
{
    use HasFactory, softDeletes, notifiable;

    protected $table = 'admin';
    protected $dateFormat = 'U';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'email',
        'email_verified_at',
        'user_firstname',
        'user_lastname',
        'password',
        'remember_token',
        'user_activated',
        'user_rol',
        'created_at',
        'updated_at',
    ];
}
