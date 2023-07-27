<?php

//Tips and tricks
// Can use the request() icw dd();


namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FamilyController extends Controller
{

    // use the right folder + page. Like FolderName.index
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
        $familymembers = Family::findOrFail($id);

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
        $dataFields = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email'],
        ]);
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

        return redirect('/')->with('message', 'Familie succesvol toegevoegd!');
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
            'name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email'],
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

