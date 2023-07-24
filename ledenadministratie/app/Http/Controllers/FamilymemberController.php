<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Familymember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FamilymemberController extends Controller
{

    // Show familymember create form
    public function create() {
        return view('familymembers.create');
    }

    // Store familymember data
    public function store(Request $request)
    {
        $dataFields = $request->validate([
            'name' => 'required',
            'date_of_birth' => 'required|date_format:d-m-Y',
            'email' => ['required', 'email'], Rule::unique('familymembers'),
        ]);

        // Optional fields, but if filled, its added
        if ($request->filled('tags')) {
            $dataFields['tags'] = $request->input('tags');
        }
        // Stores the picture in the folder pictures
        if ($request->hasFile('picture')) {
            $dataFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        // Set data of birth_of_date to right format to save in database
        $dataFields['date_of_birth'] = \DateTime::createFromFormat('d-m-Y', $dataFields['date_of_birth'])->format('Y-m-d');

        Familymember::create($dataFields);

        return redirect('/')->with('message', 'Familielid succesvol toegevoegd!');
    }
}
