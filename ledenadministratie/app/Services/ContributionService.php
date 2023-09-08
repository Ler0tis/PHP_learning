<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Familymember;

class ContributionService {


    public function updateFamilyMembersMembership(Contribution $contribution) {

        $allFamilymembers = Familymember::all();

        foreach ($allFamilymembers as $familymember) {

            if ($familymember->membership_id === null) {
                // Calculate age based on date_of_birth for the calculation
                $age = Carbon::parse($familymember->date_of_birth)->age;
                // Is age between min_ and max_age?
                if ($age >= $contribution->min_age && $age <= $contribution->max_age) {
                    // Add membership_id to familymember
                    $familymember->membership_id = $contribution->membership_id;
                    $familymember->save();
                }
            }
        }
    }

    public function calculateAmountPerYear($membershipId, $baseAmount)
    {
        $membership = Membership::find($membershipId);
        // If membership_id = NULL, return baseamount
        if (!$membership) {
            return $baseAmount;
        }

        $contribution = $membership->contribution()->first();

        // If there is a membership, calculate the discount based on baseAmount 
        if ($contribution) {
            $discount = $contribution->discount;
            $calculatedDiscount = $baseAmount * ($discount / 100);
            $calculatedAmountPerYear = $baseAmount - $calculatedDiscount;
        } else {
            $calculatedAmountPerYear = $baseAmount;
        }

        return $calculatedAmountPerYear;
    }

    
}
