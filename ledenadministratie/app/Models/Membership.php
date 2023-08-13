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

    public function getBaseContribution() {
        return $this->contribution->amount;
    }

    public function getDiscount($age) {
        return $this->contribution->age_limit <= $age ? $this->contribution->discount : 0;
    }

    // Define relation between membership and familymember
    public function familymember() {
        return $this->belongsTo(Familymember::class);
    }

    // Define relation for contribution
    public function contribution() {
        return $this->hasMany(Contribution::class);
    }
}
