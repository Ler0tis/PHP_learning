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

    public static function rules($familymember = null)
    {
        $familyId = optional($familymember)->family_id; // Get the family_id is available

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('familymembers')->where(function ($query) use ($familyId, $familymember) {
                    // Name must be unique within the same family, if family_id is entered
                    if ($familyId) {
                        $query->where('family_id', $familyId);
                    }
                    // If member exist, ignore unique check
                    if ($familymember) {
                        $query->where('id', '!=', $familymember->id);
                    }
                    // If family_id = empty (with new member) only check for name
                    if (!$familyId && request()->input('family_id')) {
                        $query->where('family_id', request()->input('family_id'));
                    }
                    return $query;
                }),
            ],
            'date_of_birth' => [
                'required',
                'date_format:d-m-Y',
                'before_or_equal:today',
                'after_or_equal:' . Carbon::now()->subYears(100)->format('d-m-Y'),
                Rule::unique('familymembers')->ignore($familymember),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('familymembers')->where(function ($query) use ($familymember) {
                    // Email must be unique if email has any changes
                    if ($familymember && $familymember->email === request()->input('email')) {
                        return $query->whereNull('email');
                    }
                    return $query;
                })->ignore($familymember),
            ],
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'family_id' => 'nullable|exists:families,id',
        ];

        return $rules;
    }

    public function membership() {
        return $this->belongsTo(Membership::class);
    }
}
