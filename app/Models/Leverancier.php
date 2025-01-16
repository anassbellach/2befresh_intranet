<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leverancier extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'leverancier';
    protected $dateFormat = 'U';
    protected $primaryKey = 'leverancier_id';
    protected $fillable = [
        'leverancier_bedrijfsnaam',
        'leverancier_email',
        'leverancier_telefoon',
        'leverancier_sinds',
        'leverancier_adres',
        'leverancier_postcode',
        'leverancier_plaats',
        'leverancier_land',
        'latitude',
        'longitude',
        'leverancier_actief',
    ];
}
