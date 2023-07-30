<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Family;
use App\Models\Familymember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;





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

    // Show edit form for Family members
    public function edit(Familymember $familymember)
    {
        return view('familymembers.edit', ['familymember' => $familymember]);
    }


    public function update(Request $request, Familymember $familymember) {

        // dd($request->all());
        $dataFields = $request->validate([
            'name' => 'required|unique:familymembers,name,|string|max:255' . $familymember->id,
            'date_of_birth' => [
                'required',
                'date_format:d-m-Y',
                'before_or_equal:today',
                'after_or_equal:' . Carbon::now()->subYears(100)->format('d-m-Y'),

            ],
            'email' => 'required|email',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'family_id' => 'nullable|exists:families,id',
        ]);

        // Set data of birth_of_date to right format to save in database
        $dataFields['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

        // Stores the picture in the folder pictures instead of DB 
        if ($request->hasFile('picture')) {
            $dataFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }


        $familymember->update($dataFields);

        // return redirect()->route('families.show', ['id' => $familymember->family_id])
        //     ->with('message', 'Familymember updated!');

        return redirect('/')->with('message', 'Familymember updated.');
        


        //HANDMATIG URL AANMAKEN EN REDIRECTEN (WERKT)
        //return redirect('/families/' . $familymember->family_id)->with('message', 'Familymember updated!');

    }

    public function destroy($id)
    {
        $familyMember = Familymember::findOrFail($id);
        $familyMember->delete();
        
        return redirect('/')->with('message', 'Familymember is succesfully deleted');
    }

}
