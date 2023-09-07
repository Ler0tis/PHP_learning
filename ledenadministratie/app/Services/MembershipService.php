<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Membership;

class MembershipService
{

    public function selectMembership($dateOfBirth)
    {
        $birthDate = Carbon::createFromFormat('d-m-Y', $dateOfBirth);
        $currentDate = Carbon::now();

        $age = $birthDate->diffInYears($currentDate);

        $membership = Membership::whereHas('contribution', function ($query) use ($age) {
            $query->where('min_age', '<=', $age)->where('max_age', '>=', $age);
        })->first();


        return $membership;
    }


}