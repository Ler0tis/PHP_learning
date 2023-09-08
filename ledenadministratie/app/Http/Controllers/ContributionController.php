<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Membership;
use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\Log;
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

        // Send variables to the view
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


    public function store(Request $request, Contribution $contribution, Family $familyId) {

        try {
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

        } catch (\Exception $e) {
            Log::error('Error while creating the contribution: ' . $e->getMessage());

            return back()->with('error', 'There is an error while creating the contribution.');
        }

    }

    public function edit($id)
    {

        $contribution = Contribution::findOrFail($id);
        $memberships = Membership::all(['*']);

        return view('contributions.edit', compact('contribution', 'memberships'));
    }

    public function update(Request $request, Contribution $contribution)
    {
        try {
            $dataFields = $request->validate(Contribution::rules($contribution));

            $contribution->update($dataFields);

            // Get the contribution from DB
            $updatedContribution = Contribution::findOrFail($contribution->id);

            $updatedContribution->update($dataFields);

            // Call update_method from Service to update the new data for contribution 
            $this->contributionService->updateFamilyMembersMembership($updatedContribution);

            return redirect()->route('contributions.index')->with('message', 'Contribution succesfully updated');

        } catch (\Exception $e) {
            Log::error('Error while updating the contribution: ' . $e->getMessage());

            return back()->with('error', 'There is an error while updating the contribution.');
        }
    }

    public function destroy($id)
    {
        try {
            $contribution = Contribution::findOrFail($id);
            $contribution->delete();

            return redirect()->route('contributions.index')->with('message', 'Contribution is succesfully deleted');

        } catch (\Exception $e) {
            Log::error('Error while deleting the contribution: ' . $e->getMessage());

            return back()->with('error', 'There is an error while deleting the contribution.');
        }
    }
}