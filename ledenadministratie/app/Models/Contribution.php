<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contribution extends Model
{
    use HasFactory;

    protected static function boot() {
        parent::boot();

        // Event listener for creating Event as set amount to 100 with new Contribution ( also see migration)
        static:: creating(function ($contribution) {
            $contribution->amount = 100;
        });
    }

    protected $fillable = [
        'membership_id',
        'min_age',
        'max_age',
        'discount',
        'financial_year_id',
    ];

    // Should be a error message when using a double membership for contribution?? Still TODO
    public static function rules($contribution = null)
    {
        $rules = [
            'membership_id' => [
                'nullable',
                'exists:memberships,id',
                Rule::unique('contributions')->ignore($contribution),
                function ($attribute, $value, $fail) use ($contribution) {
                    // Error message when membership_id is already used
                    $existingContribution = Contribution::where('membership_id', $value)->where('id', '!=', optional($contribution)->id)->first();
                    if ($existingContribution) {
                        $fail('The selected membership has already been used.');
                    }
                }
            ],
            'min_age' => 'required|integer|min:0',
            'max_age' => [
                'required',
                'integer',
                'gt:min_age',
                'max:100',
            ],
            'discount' => 'required|numeric',
            // 'amount' => 'required|numeric',
            'financial_year_id' => 'nullable|exists:financial_year,id'
        ];

        return $rules;
    }

    // Accessor to add symbol to an input or view field
    // public function getAmountWithSymbolAttribute()
    // {
    //     return '€' . $this->attributes['amount'];
    // }

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


