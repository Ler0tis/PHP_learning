<?php

//Tips and tricks

// dd($request->all());


namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Membership;
use App\Models\Familymember;
use Illuminate\Http\Request;
use App\Services\ContributionService;
use App\Http\Controllers\ContributionController;

class FamilyController extends Controller
{

    // Show all families Last added is first in column
    public function index()
    {   
        return view('families.index', [
            'families' => Family::latest()->filter(request(['tag',
            'search']))->paginate(16)
        ]);
    }

    // Show single family
    public function show($id, ContributionService $contributionService)
    {
        $family = Family::findOrFail($id);
        $familymembers = Familymember::where('family_id', $id)->get();

        $calculatedAmounts = []; // An array to store the calculated amount for members

        foreach ($familymembers as $familymember) {
            $membershipId = $familymember->membership_id;
            $calculatedAmountPerYear = $contributionService->calculateAmountPerYear($membershipId, 100);
            $calculatedAmounts[$familymember->id] = $calculatedAmountPerYear;
        }

        return view('families.show', compact('family', 'familymembers', 'calculatedAmounts'));
    }

    // Show Create Form
    public function create()
    {
        return view('families.create');
    }

    // Store familie data
    public function store(Request $request) {
        $dataFields = $request->validate(Family::rules());
        // Optional fields, but if filled, its added
        if($request->filled('tags')) {
            $dataFields['tags'] = $request->input('tags');
        }

        if ($request->filled('website')) {
            $dataFields['website'] = $request->input('website');
        }

        if ($request->filled('description')) {
            $dataFields['description'] = $request->input('description');
        }

        // Stores the picture in the folder pictures
        if($request->hasFile('picture')) {
            $dataFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        $dataFields['user_id'] = auth()->id();

        Family::create($dataFields);

        return redirect('/')->with('message', 'Family succesfully added!');
    }

    public function edit(Family $family) {
        return view('families.edit', ['family' => $family]);
    }

    // Update Family
    public function update(Request $request, Family $family) {
        $dataFields = $request->validate(Family::rules($family));
        // Optional fields, but if filled, its added
        if ($request->filled('tags')) {
            $dataFields['tags'] = $request->input('tags');
        }

        if ($request->filled('website')) {
            $dataFields['website'] = $request->input('website');
        }

        if ($request->filled('description')) {
            $dataFields['description'] = $request->input('description');
        }

        // Stores the picture in the folder pictures HEB IK DIT NOG NODIG?
        if ($request->hasFile('picture')) {
            $dataFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        $family->update($dataFields);

        return back()->with('message', 'Family succesfully updated');
    }

    // Delete family
    public function destroy(Family $family) {
        // Is logged in user owner?
        if ($family->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $family->delete();
        return redirect('/')->with('message', 'Family succesfully deleted');
    }

    // Manage Families and show them on beheer families (manage pagina)
    public function manage() {
        return view('families.manage', ['families' => auth()->user()->families]);
    }


    // Function to calculate the contribution based on the discount
    protected function calculateAmountPerYear($membershipId, $baseAmount) {
        $membership = Membership::find($membershipId);
        $contribution = $membership->contribution;

        if ($contribution) {
            $discount = $contribution->discount;
            $calculatedDiscount = $baseAmount * ($discount / 100);
            $calculatedAmountPerYear = $baseAmount - $calculatedDiscount;
        } else {
            $calculatedAmountPerYear = $baseAmount;
        }

        return $calculatedAmountPerYear;
    }

    public function getFamilyContributions($familyId) {
        $familymembers = Familymember::where('family_id', $familyId)->get();
        $totalContribution = 0;

        foreach ($familymembers as $familymember) {
            $membershipId = $familymember->membership_id;
            $contribution = $this->calculateAmountPerYear($membershipId, 100);
            $totalContribution += $contribution;
        }

        return $totalContribution;
    }
}

