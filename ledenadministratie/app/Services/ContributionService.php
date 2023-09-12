<?php 

namespace App\Services;

use Carbon\Carbon;
use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Familymember;
use Illuminate\Support\Facades\Log;

class ContributionService {


    public function updateFamilyMembersContribution(Contribution $contribution)
    {
        $allFamilymembers = Familymember::all();

        foreach ($allFamilymembers as $familymember) {

            // Calculate age based on date_of_birth for the calculation
            $age = Carbon::parse($familymember->date_of_birth)->age;

            // Calcualte the right age
            Log::info("Familymember ID: {$familymember->id}, Age: $age");

            // Is age between min_ and max_age?
            if ($age >= $contribution->min_age && $age <= $contribution->max_age) {
                
                // Add membership_id to familymember
                $familymember->membership_id = $contribution->membership_id;
                $familymember->save();

                
                Log::info("Familymember ID: {$familymember->id} has a new membership (ID: {$contribution->membership_id})");
            } else {
                
                Log::info("Familymember ID: {$familymember->id} (Age: $age) does not match age criteria.");
            }
        }
    }


    public function calculateAmountPerYear($membershipId, $baseAmount)
    {
        $membership = Membership::find($membershipId);
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
