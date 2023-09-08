<?php

namespace App\Providers;

use App\Models\Membership;
use App\Models\Familymember;
use App\Services\MembershipService;
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
        $this->app->bind(MembershipService::class, function ($app) {
            return new MembershipService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_name_in_family', function ($attribute, $value, $parameters, $validator) {

            $familyId = $parameters[0];
            $familymemberId = isset($parameters[1]) ? $parameters[1] : null;

            $exists = Familymember::where('name', $value)
                ->where('family_id', $familyId)
                ->where('id', '!=', $familymemberId)
                ->exists();

            return !$exists; // Return true if name is unique within family
        });
    }

}
