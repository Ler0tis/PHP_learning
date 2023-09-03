<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Family;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use App\Services\MembershipService;



class ContributionController extends Controller {

    // SERVICES //
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }


    public function index() {
        $financialYears = FinancialYear::all(['*']);
        $contributions = Contribution::with('membership', 'financialYear')->get(['*']);

        return view('contributions.index', compact('financialYears', 'contributions'));
    }

    public function create() {
        $memberships = Membership::all(['*']);
        $financialYears = FinancialYear::all(['*']);

        $contribution = new Contribution();
        $contribution->membership_id = null;
        
        return view('contributions.create', compact('contribution', 'financialYears', 'memberships'));
    }

   
    public function store(Request $request, Contribution $contribution, Family $familyId) {
        $dataFields = $request->validate(Contribution::rules($contribution));

        $newMembership = $this->selectMembership($contribution->min_age);
        // Get family before you can loop trough members
        $family = Family::findOrFail($familyId);
        $familymembers = $family->familymembers;

        // Add 'membership_id' to $dataFields-array if not empty
        if (!empty($request->input('membership_id'))) {
            $dataFields['membership_id'] = $request->input('membership_id');
        } else {
            // No membership id? = null
            $dataFields['membership_id'] = null;
        }

        // Variable for current year
        $currentYear = date('Y');

        // Is current year already in database?
        $financialYear = FinancialYear::where('year', $currentYear)->first();

        // No current year, make new on.
        if (!$financialYear) {
            $financialYear = FinancialYear::create(['year' => $currentYear]);
        }

        // Connect FinancialYear to Contribution by ID
        $dataFields['financial_year_id'] = $financialYear->id;

        // Loop trough all members and assing the right membership_id
        foreach ($familymembers as $familymember) {
            $membership = $this->membershipService->selectMembership($familymember->date_of_birth);

            if ($membership) {
                $familymember->membership_id = $membership->id;
                $familymember->save();
        }

    }

        Contribution::create($dataFields);

        $contributions = Contribution::with('membership')->get(['*']);
        return view('contributions.index', compact('contributions'))->with('message', 'Contribution successfully created');
    }

    public function edit($id) {

        $contribution = Contribution::findOrFail($id);
        $memberships = Membership::all(['*']);

        return view('contributions.edit', compact('contribution', 'memberships'));
    }

    public function update(Request $request, Contribution $contribution)
    {
        $dataFields = $request->validate(Contribution::rules($contribution));
        // Remove symbol before saving to DB
        $dataFields['amount'] = preg_replace('/[^0-9.]/', '', $request->input('amount_display'));
        
        $contribution->update($dataFields);

        return redirect('/')->with('message', 'Contribution succesfully updated');
    }

    public function destroy($id) {

        $contribution = Contribution::findOrFail($id);
        $contribution->delete();

        return redirect('/')->with('message', 'Contribution is succesfully deleted');
    }
}

