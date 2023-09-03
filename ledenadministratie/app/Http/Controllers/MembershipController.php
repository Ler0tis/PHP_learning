<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\Contribution;
use Illuminate\Http\Request;


class MembershipController extends Controller
{
    public function create() {
        return view('memberships.create');
    }

    public function index() {
        $memberships = Membership::all(['*']);

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
        // No problems with RESTRICTION using Foreighn keys
        $membership = Membership::findOrFail($id);
        Contribution::where('membership_id', $membership->id)->delete();

        $membership->delete();

        return redirect('/')
            ->with('message', 'Membership is successfully deleted');
    }
}
