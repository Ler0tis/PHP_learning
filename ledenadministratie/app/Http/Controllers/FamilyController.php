<?php

//Tips and tricks
// Can use the request() icw dd();


namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{

    // use the right folder + page. Like FolderName.index
    public function index()
    {   
        return view('families.index', [
            'families' => Family::latest()->filter(request(['tag',
            'search']))->paginate(2)
        ]);
    }

    // Show single family
    public function show(Family $family)
    {
        // in plaats van $family = Family::find($id);
        return view('families.show', [
            'family' => $family
        ]);
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
            'email' => ['required', 'email']
        ]);

        Family::create($dataFields);

        return redirect('/')->with('message', 'Familie succesvol toegevoegd!');
    }
}
