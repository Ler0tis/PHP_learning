<?php

namespace App\Http\Controllers;


use App\Models\Family;
use App\Models\Familymember;
use App\Models\Membership;
use Illuminate\Http\Request;
use Carbon\Carbon;



class FamilymemberController extends Controller
{

    // Show familymember create form
    public function create($family_id = null) {
        return view('familymembers.create', compact('family_id'));
    }

    // Store familymember data
    public function store(Request $request, Familymember $familymember)
    {
        $dataFields = $request->validate(Familymember::rules());

        // Set data of birth_of_date to the right format to save in the database
        $dateOfBirth = \DateTime::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

        // Create a new Familymember instance with provided data
        $familyMember = new Familymember([
            'name' => $request->input('name'),
            'date_of_birth' => $dateOfBirth,
            'email' => $request->input('email'),
            'family_id' => $request->input('family_id'),
        ]);

        // Store the picture in the folder pictures instead of the database
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $familyMember->picture = $path;
        }

        $familyMember->save();

        return redirect('/')->with('message', 'Familymember is successfully added.');
    }


    // FAMILY MEMBERS //

    // Show edit form for Family members and the memberships from DB
    public function edit(Familymember $familymember) {
        // Retrieve all available memberships
        $memberships = Membership::all();
        
        return view('familymembers.edit', compact('familymember', 'memberships'));
    }


    public function update(Request $request, Familymember $familymember) {
        $dataFields = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => [
            'required',
            'date_format:d-m-Y',
            'before_or_equal:today',
            'after_or_equal:' . Carbon::now()->subYears(100)->format('d-m-Y'),
            ],
            'email' => 'required|email',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'family_id' => 'nullable|exists:families,id',
            'membership_id' => 'nullable|exists:memberships,id',
            ]);
        
        // Set data of birth_of_date to the right format to save in the database
        $dataFields['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');
        
        // If a membership is selected, associate it with the family member
        if ($request->has('membership_id')) {
        $familymember->membership()->associate($request->input('membership_id'));
        } else {
        // If no membership is selected, remove any existing association
        $familymember->membership()->dissociate();
        }
        
        // Update the family member details
        $familymember->update($dataFields);
        
        return redirect()->route('familymembers.edit', ['familymember' => $familymember->id])
        ->with('message', 'Familymember updated!');
    }
        //HANDMATIG URL AANMAKEN EN REDIRECTEN (WERKT)
        //return redirect('/families/' . $familymember->family_id)->with('message', 'Familymember updated!');

    public function destroy($id)
    {
        $familyMember = Familymember::findOrFail($id);
        $familyMember->delete();
        
        return redirect('/')->with('message', 'Familymember is succesfully deleted');
    }

    

}
