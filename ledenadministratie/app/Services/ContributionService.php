<?php 

namespace App\Services;

use App\Models\Membership;

class ContributionService {
    public function calculateAmountPerYear($membershipId, $baseAmount)
    {
        $membership = Membership::find($membershipId);
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
