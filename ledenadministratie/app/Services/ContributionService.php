<?php 

namespace App\Services;

use App\Models\Membership;

class ContributionService {

    // public function recalculateAndRefreshData(Contribution $contribution)
    // {
    //     $newMembership = selectMembership($contribution->familymember->date_of_birth);
    //     $newcontribution = calculateAmountPerYear($newMembership->id, $contribution->amount);

    //     $contribution->update([
    //         'membership_id' => $newMembership->id,
    //         'amount' => $newContribution,
    //         // ... andere velden ...
    //     ]);

    //     $familymembers = FamilyMember::where('membership_id', $contribution->membership_id)->get();

    //     foreach ($familymembers as $familymember) {
    //         $familymember->update([
    //             'membership_id' => $newMembership->id,
    //             'contribution' => $newContribution,
    //             // ... andere velden ...
    //         ]);
    //     }

    // }
    
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
