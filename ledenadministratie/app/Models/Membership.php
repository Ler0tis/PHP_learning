<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'familymember_id',
        'description',
    ];

    public static function rules($membership = null) {
        $rules = [
            'familymember_id' => 'nullable|exists:familymembers,id',
            'description' => 'required|unique:memberships|string|max:55',
        ];

        return $rules; 
    }


    ////////////////////// RELATIONS //////////////////////
    public function familymember() {
        return $this->belongsTo(Familymember::class);
    }

    
    public function contribution() {
        return $this->hasOne(Contribution::class);
    }
}
