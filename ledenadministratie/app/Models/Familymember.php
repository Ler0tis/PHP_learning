<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Familymember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'family_id',
        'date_of_birth',
        'email',
        'picture',
    ];

    public static function rules($familymember = null) {
        $rules = [
            'name' => 'required|unique:familymembers|string|max:255',
            'date_of_birth' => [
                'required',
                'date_format:d-m-Y',
                'before_or_equal:today',
                'after_or_equal:' . Carbon::now()->subYears(100)->format('d-m-Y'),
            ],
            'email' => 'required|email|unique:familymembers',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'family_id' => 'nullable|exists:families,id',
        ];

        if ($familymember) {
            $rules['name'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('familymembers')->ignore($familymember->id),
            ];
            $rules['date_of_birth'] = [
                'required',
                'date_format:d-m-Y',
                'before_or_equal:today',
                'after_or_equal:' . Carbon::now()->subYears(100)->format('d-m-Y'),
                Rule::unique('familymembers')->ignore($familymember->id),
            ];
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('familymembers')->ignore($familymember->id),
            ];
        }

        return $rules;
    }

    public function membership() {
        return $this->belongsTo(Membership::class);
    }
}
