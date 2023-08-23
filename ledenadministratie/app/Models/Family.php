<?php

namespace App\Models;

use App\Models\Familymember;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;


    // OR in AppserviceProvider.php in Boot() Model::unguard(); and import class there. Need to specify exactly whats goes in DB (As in FamilyController.php)
    protected $fillable = [
        'name',
        'tags',
        'address',
        'email',
        'website',
        'description',
        'user_id'];

    public function scopeFilter($query, array $filters) {
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }
        if ($filters['search'] ?? false) {
            $query->where('name', 'like', '%' . request('search') . '%')
            ->orWhere('address', 'like', '%' . request('search') . '%')
            ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    public static function rules($family = null)
    {
        $rules = [
            // Validation that the name can be the same, but address has to be different
            'name' => 'required',
            'address' => [
                'required',
                Rule::unique('families')->where(function ($query) use ($family) {
                    $query->where('name', request('name'));

                    if ($family) {
                        $query->where('id', '!=', $family->id);
                    }
                }),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('families')->ignore($family),
                
            ],
        ];

        return $rules;
    }

    //Relation between Family and their members
    public function familymembers()
    {
        return $this->hasMany(Familymember::class);
    }
    
}
