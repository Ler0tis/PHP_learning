<?php

namespace App\Http\Controllers;

use App\Models\Family;
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
    public function store(Request $request)
    {
        $dataFields = $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:d-m-Y',
            'email' => 'required|email',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'family_id' => 'nullable|exists:families,id',
        ]);

        // Set data of birth_of_date to right format to save in database
        $dateOfBirth = \DateTime::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

        // Create familymember with provided data
        $familyMember = new Familymember([
            'name' => $request->input('name'),
            'date_of_birth' => $dateOfBirth,
            'email' => $request->input('email'),
        ]);

        // IS family_id is provided, associate the familymember with family
        if ($request->has('family_id')) {
            $familyMember->family_id = $request->input('family_id');
        }


        $familyMember->save();

        // Stores the picture in the folder pictures
        if ($request->hasFile('picture')) {
            $dataFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }

    

        return redirect('/')->with('message', 'Familielid succesvol toegevoegd!');
    }
}
