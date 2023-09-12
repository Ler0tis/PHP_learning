<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Familymember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MembershipController extends Controller
{
    public function create() {
        return view('memberships.create');
    }

    // Shows available memberships on Membership page
    public function index() {
        $memberships = Membership::all(['*']);

        return view('memberships.index', compact('memberships'));
    }

    public function store(Request $request) 
    {
        $validatedData = $request->validate(Membership::rules());

        try {
            if ($request->filled('description')) {
                $validatedData['description'] = $request->input('description');
            }

            Membership::create($validatedData);

            return redirect('memberships')->with('message', 'Membership is created');

        } catch (\Exception $e) {
            Log::error('Error while creating the membership: ' . $e->getMessage());

            return back()->with('error', 'There is an error while creating the membership.');
        }
    }

    public function edit(Membership $membership){
        
        return view('memberships.edit', ['membership' => $membership]);
    }

    public function update(Request $request, Membership $membership) 
    {
        $validatedData = $request->validate(Membership::rules());

        try {
            if ($request->filled('description')) {
                $validatedData['description'] = $request->input('description');
            }

            $membership->update($validatedData);

            return redirect('memberships')->with('message', 'Membership is updated');

        } catch (\Exception $e) {
            Log::error('Error while updating the familymember: ' . $e->getMessage());

            return back()->with('error', 'There is an error while updating the familymember.');
        }
    }

    public function destroy($id)
    {
        try {
            $membership = Membership::findOrFail($id);

            // Delete related contributions
            Contribution::where('membership_id', $membership->id)->delete();

            // Get the familymembers that have this membership_id
            $familymembers = Familymember::where('membership_id', $membership->id)->get();

            // Put membership_id with these familymembers on NULL
            foreach ($familymembers as $familymember) {
                $familymember->membership_id = null;
                $familymember->save();
            }

            // Delete the membership
            $membership->delete();

            return redirect('memberships')
                ->with('message', 'Membership and related contribution are successfully deleted');

        } catch (\Exception $e) {
            Log::error('Error while deleting the membership: ' . $e->getMessage());

            return back()->with('error', 'There is an error while deleting the membership.');
        }
    }

}
