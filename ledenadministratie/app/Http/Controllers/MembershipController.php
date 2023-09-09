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

    public function store(Request $request) {

        try {
            $dataFields = $request->validate(Membership::rules());

            if ($request->filled('description')) {
                $dataFields['description'] = $request->input('description');
            }

            Membership::create($dataFields);

            return redirect('memberships')->with('message', 'Membership is created');

        } catch (\Exception $e) {
            Log::error('Error while creating the membership: ' . $e->getMessage());

            return back()->with('error', 'There is an error while creating the membership.');
        }
    }

    public function edit(Membership $membership){
        
        return view('memberships.edit', ['membership' => $membership]);
    }

    public function update(Request $request, Membership $membership) {

        try {
            $dataFields = $request->validate(Membership::rules());

            if ($request->filled('description')) {
                $dataFields['description'] = $request->input('description');
            }

            $membership->update($dataFields);

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

            // Verwijder gerelateerde contributies
            Contribution::where('membership_id', $membership->id)->delete();

            // Haal de bijbehorende familymembers op
            $familymembers = Familymember::where('membership_id', $membership->id)->get();

            // Zet membership_id op NULL voor elk van de familymembers
            foreach ($familymembers as $familymember) {
                $familymember->membership_id = null;
                $familymember->save();
            }

            // Verwijder het membership zelf
            $membership->delete();

            return redirect('memberships')
                ->with('message', 'Membership is successfully deleted');

        } catch (\Exception $e) {
            Log::error('Error while deleting the membership: ' . $e->getMessage());

            return back()->with('error', 'There is an error while deleting the membership.');
        }
    }

}
