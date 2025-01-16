<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, softDeletes;

    protected $dateFormat = 'U';

    protected $table = 'contactpersoon';

    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'contact_naam',
        'contact_geboortedatum',
        'contact_geslacht',
        'contact_telefoon',
        'contact_telefoon_kantoor',
        'contact_mail',
        'contact_mail_2',
        'contact_mail_3',
        'contact_voorkeur',
        'contact_actief',
    ];

}
