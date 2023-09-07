<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Familymember;

class ContributionService {


    public function updateFamilyMembersMembership(Contribution $contribution) {
        // Haal alle familymembers op die aan de betreffende familie zijn gekoppeld
        $allFamilymembers = Familymember::all();

        foreach ($allFamilymembers as $familymember) {
            // Controleer of membership_id NULL is
            if ($familymember->membership_id === null) {
                // Bereken de leeftijd van de familymember
                $age = Carbon::parse($familymember->date_of_birth)->age;

                // Controleer of de leeftijd binnen de criteria van de contributie valt
                if ($age >= $contribution->min_age && $age <= $contribution->max_age) {
                    // Wijs het nieuwe membership_id toe
                    $familymember->membership_id = $contribution->membership_id;
                    $familymember->save();
                }
            }
        }
    }



    public function calculateAmountPerYear($membershipId, $baseAmount)
    {
        $membership = Membership::find($membershipId);

        if (!$membership) {
            return $baseAmount;
        }

        $contribution = $membership->contribution()->first();

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
