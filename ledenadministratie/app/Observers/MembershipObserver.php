<?php

namespace App\Observers;

use App\Models\Membership;
use App\Models\Familymember;

class MembershipObserver
{
    /**
     * Handle the Membership "created" event.
     *
     * @param  \App\Models\Membership  $membership
     * @return void
     */
    public function created(Membership $membership)
    {
        //
    }

    /**
     * Handle the Membership "updated" event.
     *
     * @param  \App\Models\Membership  $membership
     * @return void
     */
    public function updated(Membership $membership)
    {
        // Find all Familymembers that are associated with Membership
        $familymembers = Familymember::where('membership_id', $membership->id)->get();

        foreach ($familymembers as $familymember) {
            // Calculate the age based on the familymember's date_of_birth
            $birthDate = $familymember->date_of_birth;
            $currentDate = now();
            $age = $birthDate->diffInYears($currentDate);

            // Update the Familymember's age if it falls within the updated Membership's age range
            if ($age >= $membership->min_age && $age <= $membership->max_age) {
                $familymember->age = $age;
            } else {
                // Set age to NULL if it doesn't fall within an age range
                $familymember->age = null;
            }

            $familymember->save();
        }
    }

    /**
     * Handle the Membership "deleted" event.
     *
     * @param  \App\Models\Membership  $membership
     * @return void
     */
    public function deleted(Membership $membership)
    {
        //
    }

    /**
     * Handle the Membership "restored" event.
     *
     * @param  \App\Models\Membership  $membership
     * @return void
     */
    public function restored(Membership $membership)
    {
        //
    }

    /**
     * Handle the Membership "force deleted" event.
     *
     * @param  \App\Models\Membership  $membership
     * @return void
     */
    public function forceDeleted(Membership $membership)
    {
        //
    }
}
