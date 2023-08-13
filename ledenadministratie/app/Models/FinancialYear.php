<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    use HasFactory;

    protected $fillable = ['year'];

    


    // Relation with contributions
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
}
