<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klant extends Model
{
    use HasFactory, SoftDeletes;

    protected $dateFormat = "U";

    protected $primaryKey = "klant_id";

    protected $table = 'klant';

    protected $fillable = [
        'klant_bedrijfsnaam',
        'klant_kvk',
        'klant_mail',
        'klant_telefoon',
        'klant_sinds',
        'klant_adres',
        'klant_postcode',
        'klant_plaats',
        'klant_land',
        'klant_actief',
        'latitude',
        'longitude',
        'created_at'
    ];

}
