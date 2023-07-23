<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    // OR in AppserviceProvider.php in Boot() Model::unguard(); and import class there. Need to specify exactly whats goes in DB (As in FamilyController.php)
    protected $fillable = ['name', 'tags', 'address', 'email', 'website',
     'description', 'picture', 'user_id'];

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
}
