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
        $financialYears = FinancialYear::all(); // Deze hoeft niet meer als het goed is ivm de automatische die wordt gedana in STORE en in de view ook niet van create

        $contribution = new Contribution();
        $contribution->membership_id = null;
        
        return view('contributions.create', compact('contribution', 'financialYears', 'memberships'));
    }

   
    public function store(Request $request)
    {
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

    // Bij het berekenen van het totaalbedrag
    // Bij het berekenen van het totaalbedrag
    // public function calculateAmount(Request $request, Family $family)
    // {
    //     // Altijd het basisbedrag van €100 gebruiken
    //     $baseAmount = 100;

    //     $membershipId = $request->input('membership');
    //     $membership = Membership::find($membershipId);

    //     if (!$membership) {
    //         return redirect()->back()->with('message', 'Geen bijpassend lidmaatschap gevonden.');
    //     }

    //     $contribution = Contribution::where('membership_id', $membershipId)->first();

    //     if (!$contribution) {
    //         return redirect()->back()->with('message', 'Geen bijpassende contributie gevonden.');
    //     }

    //     $discount = $contribution->discount ?? 0; // Neem aan dat er geen korting is als er geen contributie is

    //     $calculatedAmountPerYear = $baseAmount * (1 - ($discount / 100));

    //     return view('family.show.index', compact('family', 'calculatedAmountPerYear'));
    // }




    // public function showContributionsByYear(FinancialYear $year)
    // {
    //     $contributions = $year->contributions()->with('membership')->get();
    //     return view('contributions.show_by_year', compact('contributions', 'year'));
    // }
}

