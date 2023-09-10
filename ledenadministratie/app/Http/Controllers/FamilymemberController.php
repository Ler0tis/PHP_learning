<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Family;
use App\Models\Membership;
use App\Models\Familymember;
use Illuminate\Http\Request;
use App\Services\MembershipService;
use Illuminate\Support\Facades\Log;

class FamilymemberController extends Controller
{

    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    // Show familymember create form
    public function create($family_id = null)
    {
        return view('familymembers.create', compact('family_id'));
    }

    // Store familymember data
    public function store(Request $request, Familymember $familymember) 
    {
        $validatedData = $request->validate(Familymember::rules($familymember));

        try {
        
            $dateOfBirth = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

            $familyMember = new Familymember([
                'name' => $request->input('name'),
                'date_of_birth' => $dateOfBirth,
                'email' => $request->input('email'),
                'family_id' => $request->input('family_id'),
            ]);

            if ($request->hasFile('picture')) {
                $path = $request->file('picture')->store('pictures', 'public');
                $familyMember->picture = $path;
            }

            // Connect the right membership to familymember
            $membership = $this->membershipService->selectMembership($request->input('date_of_birth'));
            $familyMember->membership()->associate($membership);

            $familyMember->save();

            $family = Family::find($request->input('family_id'));
            return redirect()->route('families.show', ['family' => $family->id])
            ->with('message', 'Familymember is successfully added.');

        } catch (\Exception $e) {
            Log::error('Error while creating the familymember: ' . $e->getMessage());

            return back()->with('error', 'There is an error while creating the familymember.');
        }
    }

    // Show edit form for Family members
    public function edit(Familymember $familymember)
    {
        // Retrieve available memberships
        $memberships = Membership::all(['*']);

        return view('familymembers.edit', compact('familymember', 'memberships'));
    }


    public function update(Request $request, Familymember $familymember) {

        $validatedData = $request->validate(Familymember::rules($familymember));

        try{
            

            $formattedDateOfBirth = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'));
            $formattedDateOfBirth = $formattedDateOfBirth->format('Y-m-d');

            $familymember->name = $validatedData['name'];
            $familymember->email = $validatedData['email'];

            if ($request->hasFile('picture')) {
                $path = $request->file('picture')->store('pictures', 'public');
                $familymember->picture = $path;
            }
            // CHECK if birthdate is changed
            if ($familymember->date_of_birth !== $formattedDateOfBirth) {
                $membership = $this->membershipService->selectMembership($request->input('date_of_birth'));
                $familymember->membership()->associate($membership);
            }

            // Update from date_of_birth
            $familymember->date_of_birth = $formattedDateOfBirth;
            $familymember->save();


            return redirect()->route('families.show', ['family' => $familymember->family_id])
                ->with('message', 'Familymember is successfully updated.');

        } catch (\Exception $e) {
            Log::error('Error while updating the familymember: ' . $e->getMessage());

            return back()->with('error', 'There is an error while updating the familymember.');
        }
    }

    public function destroy($id) {
        try {
            $familyMember = Familymember::findOrFail($id);
            $familyMember->delete();

            $familyId = $familyMember->family_id;

            return redirect()->route('families.show', ['family' => $familyId])
            ->with('message', 'Familymember is successfully deleted');

        } catch (\Exception $e) {
            Log::error('Error while deleting the familymember: ' . $e->getMessage());

            return back()->with('error', 'There is an error while deleting the familymember.');
        } 
    }
}