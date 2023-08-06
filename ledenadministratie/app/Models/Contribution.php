<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'min_age',
        'max_age',
        'amount',
        'discount', // CONTRIBUTION
    ];

    public static function rules($contribution = null)
    {
        $rules = [
            'membership_id' => 'nullable|exists:memberships,id',
            'min_age' => 'required|integer',
            'max_age' => 'required|integer|gt:min_age',
            'discount' => 'required|numeric',
            'amount' => 'required|numeric'
        ];

        return $rules;
    }

    // Relation between contribution and membership
    public function membership() {
        return $this->belongsTo(Membership::class);
    }
}
