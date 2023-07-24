<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familymember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'family_id',
        'date_of_birth',
        'email',
        'picture',
        'membership',
    ];
}