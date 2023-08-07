<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\Request;
use App\Models\Familymember;
use App\Models\Membership;

class ContributionController extends Controller {

    public function index() {
        
        $contributions = Contribution::with('membership')->get();
        return view('contributions.index', compact('contributions'));
    }

    public function create() {
        $memberships = Membership::all();
        
        return view('contributions.create', compact('memberships'));
    }

    public function store(Request $request)
    {
        // Valideer de ingevoerde gegevens
        $dataFields = $request->validate(Contribution::rules());

        // Maak een nieuwe contributie en sla deze op in de database
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
        $dataFields = $request->validate(Contribution::rules());

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

