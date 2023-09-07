<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Family;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use App\Services\ContributionService;



class ContributionController extends Controller
{
    // SERVICES //
    protected $contributionService;

    public function __construct(ContributionService $contributionService)
    {
        $this->contributionService = $contributionService;
    }


    public function index()
    {
        $financialYears = FinancialYear::all(['*']);
        $contributions = Contribution::with('membership', 'financialYear')->get(['*']);

        return view('contributions.index', compact('financialYears', 'contributions'));
    }

    public function create()
    {
        $memberships = Membership::all(['*']);
        $financialYears = FinancialYear::all(['*']);

        $contribution = new Contribution();
        $contribution->membership_id = null;

        return view('contributions.create', compact('contribution', 'financialYears', 'memberships'));
    }


    public function store(Request $request, Contribution $contribution, Family $familyId)
    {
        $dataFields = $request->validate(Contribution::rules($contribution));

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

        Contribution::create($dataFields);

        $this->contributionService->updateFamilyMembersMembership($contribution);

        $contributions = Contribution::with('membership')->get(['*']);
        return view('contributions.index', compact('contributions'))->with('message', 'Contribution successfully created');
    }

    public function edit($id)
    {

        $contribution = Contribution::findOrFail($id);
        $memberships = Membership::all(['*']);

        return view('contributions.edit', compact('contribution', 'memberships'));
    }

    public function update(Request $request, Contribution $contribution)
    {
        $dataFields = $request->validate(Contribution::rules($contribution));
        // Remove symbol before saving to DB
        // $dataFields['amount'] = preg_replace('/[^0-9.]/', '', $request->input('amount_display'));

        $contribution->update($dataFields);

        // Get the contribution from DB
        $updatedContribution = Contribution::findOrFail($contribution->id);

        // Update contribution with new data
        $updatedContribution->update($dataFields);

        // Call update_method from Service to update the new data for contribution 
        $this->contributionService->updateFamilyMembersMembership($updatedContribution);

        return redirect('/')->with('message', 'Contribution succesfully updated');
    }

    public function destroy($id)
    {

        $contribution = Contribution::findOrFail($id);
        $contribution->delete();

        return redirect('/')->with('message', 'Contribution is succesfully deleted');
    }
}