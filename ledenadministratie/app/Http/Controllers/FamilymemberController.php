<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Membership;
use App\Models\Familymember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



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

    // Show edit form for Family members and the memberships from DB
    public function edit(Familymember $familymember) {
        // Retrieve all available memberships
        $memberships = Membership::all();
        
        return view('familymembers.edit', compact('familymember', 'memberships'));
    }


    public function update(Request $request, Familymember $familymember)
    {
        $dataFields = $request->validate(Familymember::rules());

        $dataFields['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

        // If a membership is selected, associate it with the family member
        if ($request->has('membership_id')) {
            $familymember->membership()->associate($request->input('membership_id'));
        } else {
            // If no membership is selected, remove any existing association
            $familymember->membership()->dissociate();
        }

        // Custom validation rule for name/email if any changes
        $request->validate([
            'name' => [
                'sometimes',
                // Only validate if the name/email is provided and different from the original name
                'string',
                'max:255',
                Rule::unique('familymembers')->where(function ($query) use ($familymember) {
                    return $query->where('family_id', $familymember->family_id);
                })->ignore($familymember),
            ],
        ]);

        $request->validate([
            'email' => [
                'sometimes',
                'email',
                Rule::unique('familymembers')->ignore($familymember),
            ],
        ]);

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
