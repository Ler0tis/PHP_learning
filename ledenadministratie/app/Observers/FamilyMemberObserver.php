<?php

namespace App\Observers;

use App\Models\FamilyMember;

class FamilyMemberObserver
{
    /**
     * Handle the FamilyMember "created" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function created(FamilyMember $familyMember)
    {
        //
    }

    /**
     * Handle the FamilyMember "updated" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function updated(FamilyMember $familyMember)
    {
        //
    }

    /**
     * Handle the FamilyMember "deleted" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function deleted(FamilyMember $familyMember)
    {
        //
    }

    /**
     * Handle the FamilyMember "restored" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function restored(FamilyMember $familyMember)
    {
        //
    }

    /**
     * Handle the FamilyMember "force deleted" event.
     *
     * @param  \App\Models\FamilyMember  $familyMember
     * @return void
     */
    public function forceDeleted(FamilyMember $familyMember)
    {
        //
    }
}
