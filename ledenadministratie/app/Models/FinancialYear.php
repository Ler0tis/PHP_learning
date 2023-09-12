<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    use HasFactory;

    protected $fillable = ['year'];


    //////////// RELATIONS ////////////
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
}
