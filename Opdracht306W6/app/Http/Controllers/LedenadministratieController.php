<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ledenadministratie;

class LedenadministratieController extends Controller
{

    public function index() {
        return view('index', ['famlies' => Ledenadministratie::all()]);
    }
    //
    public function saveFamilie(Request $request) {

        $newFamilie = new Ledenadministratie;
        $newFamilie->naam = $request->familieNaam;
        $newFamilie->adres = $request->familieAdres;
        $newFamilie->is_complete = 0;
        $newFamilie->save();
        return view('index');
    }
}
