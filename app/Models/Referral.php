<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use HasFactory, SoftDeletes;

    protected $dateFormat = 'U';
    protected $table = 'referral_links';

    protected $fillable = [
      'titel',
      'omschrijving',
      'link',
      'referral_activated',
    ];
}
