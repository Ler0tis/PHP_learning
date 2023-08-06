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

        return view('contributions.index')->with('message', 'Contribution is created');
    }
}

