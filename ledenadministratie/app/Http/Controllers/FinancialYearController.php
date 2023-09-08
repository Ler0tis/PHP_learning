<?php

namespace App\Http\Controllers;

use App\Models\FinancialYear;

class FinancialYearController extends Controller {
    
    public function index() {
        $financialYears = FinancialYear::all();
        return view('financialyears.index', compact('financialYears'));
    }

    public function show(FinancialYear $financialYear) {
        
        $contributions = $financialYear->contributions()->with('membership')->get();
        return view('financialyears.show', compact('financialYear', 'contributions'));
    }
}
