<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Familymember;
use Illuminate\Http\Request;
use App\Models\FinancialYear;

class ContributionController extends Controller {

    public function index() {
        $financialYears = FinancialYear::all();
        $contributions = Contribution::with('membership', 'financialYear')->get();

        return view('contributions.index', compact('financialYears', 'contributions'));
    }

    public function create() {
        $memberships = Membership::all();
        $financialYears = FinancialYear::all();

        $contribution = new Contribution();
        $contribution->membership_id = null;
        
        return view('contributions.create', compact('contribution', 'financialYears', 'memberships'));
    }

   
    public function store(Request $request) {
        $dataFields = $request->validate(Contribution::rules());

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

        Contribution::create($dataFields);

        $contributions = Contribution::with('membership')->get();
        return view('contributions.index', compact('contributions'))->with('message', 'Contribution successfully created');
    }

    public function edit($id) {

        $contribution = Contribution::findOrFail($id);
        $memberships = Membership::all();

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

