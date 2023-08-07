<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_id',
        'min_age',
        'max_age',
        'amount',
        'discount',
    ];

    

    public static function rules($contribution = null)
    {
        $rules = [
            'membership_id' => 'nullable|exists:memberships,id',
            'min_age' => 'required|integer|min:0',
            'max_age' => [
                'required',
                'integer',
                'gt:min_age',
                'max: 100',
                
            ],
            'discount' => 'required|numeric',
            'amount' => 'required|numeric'
        ];

        return $rules;
    }

    // Accessor om het €-symbool aan het bedrag toe te voegen
    public function getAmountWithSymbolAttribute()
    {
        return '€ ' . $this->attributes['amount'];
    }




    // Relation between contribution and membership
    public function membership() {
        return $this->belongsTo(Membership::class);
    }
}
