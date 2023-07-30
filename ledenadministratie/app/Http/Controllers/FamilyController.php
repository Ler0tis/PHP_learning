<?php

//Tips and tricks

// dd($request->all());


namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Familymember;
use Illuminate\Http\Request;

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
    public function show($id)
    {
        $family = Family::findOrFail($id);
        $familymembers = Familymember::where('family_id', $id)->get();

        return view('families.show', compact('family', 'familymembers'));
    }

    // Show Create Form
    public function create()
    {
        return view('families.create');
    }

    // Store familie data
    // Unique  'name' => 'required, Rule::unique('families')'
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
    public function update(Request $request, Family $family)
    {
        // Is logged in user owner?
        if ($family->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $dataFields = $request->validate([
            'name' => 'required|unique:families',
            'address' => 'required|unique:families',
            'email' => 'required|email|unique:families',
        ]);
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

        // Stores the picture in the folder pictures
        if ($request->hasFile('picture')) {
            $dataFields['picture'] = $request->file('picture')->store('pictures', 'public');
        }

        $family->update($dataFields);

        return back()->with('message', 'Familie succesvol aangepast');
    }

    // Delete family
    public function destroy(Family $family) {
        // Is logged in user owner?
        if ($family->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $family->delete();
        return redirect('/')->with('message', 'Familie succesvol verwijderd');
    }

    // Manage Families and show them on beheer families (manage pagina)
    public function manage()
    {
        return view('families.manage', ['families' => auth()->user()->families]);
    }
}

