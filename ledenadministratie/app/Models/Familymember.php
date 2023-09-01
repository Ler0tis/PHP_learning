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

    public static function rules(Familymember $familymember = null)
    {
        $familyId = optional($familymember)->family_id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('familymembers')
                    ->ignore($familymember->id)
                    ->where(function ($query) use ($familyId, $familymember) {
                        $query->where('name', request('name'));

                        if ($familyId) {
                            $query->where('family_id', $familyId);
                        }

                        if ($familymember) {
                            $query->where('id', '!=', $familymember->id);
                        }

                        if (!$familyId && request('family_id')) {
                            $query->where('family_id', request('family_id'));
                        }
                    }),
            ],
            'date_of_birth' => [
                'sometimes',
                'required',
                'date_format:d-m-Y',
                'before_or_equal:today',
                'after_or_equal:' . Carbon::now()->subYears(100)->format('d-m-Y'),
                Rule::unique('familymembers')->ignore($familymember),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('familymembers')
                    ->ignore($familymember->id)
                    ->where(function ($query) use ($familymember) {
                        $query->where('email', request('email'));

                        if ($familymember && $familymember->email === request('email')) {
                            $query->orWhereNull('email');
                        }
                    }),
            ],
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'family_id' => 'nullable|exists:families,id',
        ];
    }

    // Relations
    public function membership() {
        return $this->belongsTo(Membership::class);
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }


}
