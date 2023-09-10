<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contribution extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'membership_id',
        'min_age',
        'max_age',
        'discount',
        'financial_year_id',
    ];

    public static function rules($contribution = null)
    {
        $rules = [
            'membership_id' => [
                'nullable',
                'exists:memberships,id',
                Rule::unique('contributions')->ignore($contribution),
            ],
            'min_age' => 'required|integer|min:0',
            'max_age' => [
                'required',
                'integer',
                'gt:min_age',
                'max:100',
            ],
            'discount' => 'required|numeric',
            'financial_year_id' => 'nullable|exists:financial_year,id'
        ];

        return $rules;
    }

    public function getDiscountWithSymbolAttribute() {

        return $this->attributes['discount'] . '%';
    }

    /////////// Relations between tables ////////////////
    public function membership() {
        return $this->belongsTo(Membership::class);
    }

    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }
}


