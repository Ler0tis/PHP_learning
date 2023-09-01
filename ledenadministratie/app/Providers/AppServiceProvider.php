<?php

namespace App\Providers;

use App\Models\Membership;
use App\Models\Familymember;
// use App\Observers\FamilyMemberObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_name_in_family', function ($attribute, $value, $parameters, $validator) {
            // $value = name
            // $parameters[0] is family_id
            // $parameters[1] is current familymember_id (optional. Only with familymemberid)

            $familyId = $parameters[0];
            $familymemberId = isset($parameters[1]) ? $parameters[1] : null;

            $exists = Familymember::where('name', $value)
                ->where('family_id', $familyId)
                ->where('id', '!=', $familymemberId)
                ->exists();

            return !$exists; // Return true if name is unique within family
        });

        // FamilyMember::observe(FamilyMemberObserver::class);

        // For config in MembershipOberserver to check if the age range is changed
        // Membership::observe(MembershipObserver::class);
    }
}
