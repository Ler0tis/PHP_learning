<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Familymember;
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


    public function store(Request $request, Contribution $contribution) 
    {
        $validatedData = $request->validate(Contribution::rules());

        try {
            // Default value for contribution
            $validatedData['amount'] = 100;

            // Variable for current year
            $currentYear = date('Y');

            // Is current year already in database?
            $financialYear = FinancialYear::where('year', $currentYear)->first();

            // No current year, make new on.
            if (!$financialYear) {
                $financialYear = FinancialYear::create(['year' => $currentYear]);
            }
            // Connect FinancialYear to Contribution by ID
            $validatedData['financial_year_id'] = $financialYear->id;

            Contribution::create($validatedData);

            $this->contributionService->updateFamilyMembersContribution($contribution);

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
        $validatedData = $request->validate(Contribution::rules());

        try {
            $contribution->update($validatedData);

            // Get the contribution from DB
            $updatedContribution = Contribution::findOrFail($contribution->id);

            $updatedContribution->update($validatedData);

            // Call update_method from Service to update the new data for contribution 
            $this->contributionService->updateFamilyMembersContribution($updatedContribution);

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

            // Get the correct membership
            $membership = $contribution->membership;

            // Delete the contribution
            $contribution->delete();

            // Get the familymembers connected to the membership_id
            $familyMembers = Familymember::where('membership_id', $membership->id)->get();

            // Put membership_id on NULL for those familymembers
            foreach ($familyMembers as $familyMember) {
                $familyMember->membership_id = null;
                $familyMember->save();
            }

            return redirect('contributions')
                ->with('message', 'Contribution is successfully deleted');

        } catch (\Exception $e) {
            Log::error('Error while deleting the contribution: ' . $e->getMessage());

            return back()->with('error', 'There is an error while deleting the contribution.');
        }
    }

}