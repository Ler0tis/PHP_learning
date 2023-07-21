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
            'families' => Family::all()
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
}
