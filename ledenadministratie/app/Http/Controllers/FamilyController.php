<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Familymember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\ContributionService;

class FamilyController extends Controller
{

    // Show all families Last added is first in column
    public function index()
    {
        return view('families.index', [
            'families' => Family::latest()->filter(request([
                'tag',
                'search'
            ]))->paginate(8)
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
            // Check if there is a membership for the familymember
            if ($membershipId !== null) {
                $calculatedAmountPerYear = $contributionService->calculateAmountPerYear($membershipId, 100);
            } else {
                // No membership? 
                $calculatedAmountPerYear = 0;
            }

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
        $validatedData = $request->validate(Family::rules());

        try {
        
            // Optional fields, but if filled, its added
            if ($request->filled('tags')) {
                $validatedData['tags'] = $request->input('tags');
            }

            if ($request->filled('website')) {
                $validatedData['website'] = $request->input('website');
            }

            if ($request->filled('description')) {
                $validatedData['description'] = $request->input('description');
            }

            $validatedData['user_id'] = auth()->id();

            Family::create($validatedData);

            return redirect('/')->with('message', 'Family succesfully added!');


        } catch (\Exception $e) {
            Log::error('Error while creating the family: ' . $e->getMessage());

            return back()->with('error', 'There is an error while creating the family.');
        }
        
    }

    public function edit(Family $family)
    {
        return view('families.edit', ['family' => $family]);
    }

    // Update Family
    public function update(Request $request, Family $family) {

        $validatedData = $request->validate(Family::rules($family));

        try {
        // Optional fields, but if filled, its added
        if ($request->filled('tags')) {
            $validatedData['tags'] = $request->input('tags');
        }

        if ($request->filled('website')) {
            $validatedData['website'] = $request->input('website');
        }

        if ($request->filled('description')) {
            $validatedData['description'] = $request->input('description');
        }

        $family->update($validatedData);

        return redirect('/')->with('message', 'Family succesfully updated');

        } catch (\Exception $e) {
            Log::error('Error while updating the family: ' . $e->getMessage());

            return back()->with('error', 'There is an error while updating the family.');
        }
    }
    
    public function destroy(Family $family) {

        try {
            // Is logged in user owner?
            if ($family->user_id != auth()->id()) {
                abort(403, 'Unauthorized Action');
            }

            $family->delete();
            
            return redirect()->route('families.manage')->with('message', 'Family succesfully deleted');

        } catch (\Exception $e) {
            Log::error('Error while deleting the family: ' . $e->getMessage());

            return redirect('/')->with('error', 'There is an error while deleting the family.');
        }
    }

    // Manage Families and show them on manage families
    public function manage()
    {
        return view('families.manage', ['families' => auth()->user()->families]);
    }
}