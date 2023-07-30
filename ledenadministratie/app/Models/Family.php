<?php

namespace App\Models;

use App\Models\Familymember;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    //Relation between Family and their members
    public function familymembers() {
        return $this->hasMany(Familymember::class);
    }

    // OR in AppserviceProvider.php in Boot() Model::unguard(); and import class there. Need to specify exactly whats goes in DB (As in FamilyController.php)
    protected $fillable = [
        'name',
        'tags',
        'address',
        'email',
        'website',
        'description',
        'picture',
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

    // Relations to USER. kan ik dit gebruiken voor een familielid die hoort bij een familie?
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Make sure the address and email are unique among all families/members
    public static function rules($family = null) {
        $rules = [
            'name' => 'required',
            'address' => [
                'required',
                Rule::unique('families')->ignore($family),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('families')->ignore($family),
            ],

        ];

        return $rules;
        
    }
    
}
