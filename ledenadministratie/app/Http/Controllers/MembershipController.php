<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;


class MembershipController extends Controller
{
    public function create() {
        return view('memberships.create');
    }

    public function index() {
        $memberships = Membership::all();

        return view('memberships.index', compact('memberships'));
    }

    public function store(Request $request) {
        $dataFields = $request->validate(Membership::rules());

        if ($request->filled('description')) {
            $dataFields['description'] = $request->input('description');
        }

        Membership::create($dataFields);

        return redirect('/')->with('message', 'Membership is updated');

    }

    public function edit(Membership $membership){
        
        return view('memberships.edit', ['membership' => $membership]);
    }

    public function update(Request $request, Membership $membership)
    {
        $dataFields = $request->validate(Membership::rules());

        if ($request->filled('description')) {
            $dataFields['description'] = $request->input('description');
        }

        $membership->update($dataFields);

        return redirect('/')->with('message', 'Membership is updated');

    }

    public function destroy($id) {
        $membership = Membership::findOrFail($id);
        $membership->delete();

        return redirect('/')->with('message', 'Membership is succesfully deleted');
    }
}
