<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Membership;
use App\Models\Familymember;
use App\Services\MembershipService;
use Illuminate\Http\Request;

class FamilymemberController extends Controller
{

    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    // Show familymember create form
    public function create($family_id = null)
    {
        return view('familymembers.create', compact('family_id'));
    }

    // Store familymember data
    public function store(Request $request, Familymember $familymember)
    {
        $dataFields = $request->validate(Familymember::rules($familymember));

        $dateOfBirth = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

        $familyMember = new Familymember([
            'name' => $request->input('name'),
            'date_of_birth' => $dateOfBirth,
            'email' => $request->input('email'),
            'family_id' => $request->input('family_id'),
        ]);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $familyMember->picture = $path;
        }

        // Koppel het juiste lidmaatschap aan de familymember
        $membership = $this->membershipService->selectMembership($request->input('date_of_birth'));
        $familyMember->membership()->associate($membership);

        $familyMember->save();

        return redirect('/')->with('message', 'Familymember is successfully added.');
    }

    // Show edit form for Family members and the memberships from DB
    public function edit(Familymember $familymember)
    {
        // Retrieve all available memberships
        $memberships = Membership::all(['*']);

        return view('familymembers.edit', compact('familymember', 'memberships'));
    }


    public function update(Request $request, Familymember $familymember)
    {

        $dataFields = $request->validate(Familymember::rules($familymember));

        $formattedDateOfBirth = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'));
        $formattedDateOfBirth = $formattedDateOfBirth->format('Y-m-d');

        // Overige velden bijwerken
        $familymember->name = $dataFields['name'];
        $familymember->email = $dataFields['email'];
        // ... andere velden ...
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $familymember->picture = $path;
        }
        // CHECK if birthdate is changed
        if ($familymember->date_of_birth !== $formattedDateOfBirth) {
            $membership = $this->membershipService->selectMembership($request->input('date_of_birth'));
            $familymember->membership()->associate($membership);
        }

        $familymember->date_of_birth = $formattedDateOfBirth; // Bijwerken van de geboortedatum

        $familymember->save();

        return redirect('/')->with('message', 'Familymember is successfully updated.');
    }

    //HANDMATIG URL AANMAKEN EN REDIRECTEN (WERKT)
    //return redirect('/families/' . $familymember->family_id)->with('message', 'Familymember updated!');

    public function destroy($id)
    {
        $familyMember = Familymember::findOrFail($id);
        $familyMember->delete();

        return redirect('/')->with('message', 'Familymember is succesfully deleted');
    }

    // public function selectMembership($dateOfBirth)
    // {
    //     $birthDate = Carbon::createFromFormat('d-m-Y', $dateOfBirth);
    //     $currentDate = Carbon::now();

    //     $age = $birthDate->diffInYears($currentDate);

    //     $membership = Membership::whereHas('contribution', function ($query) use ($age) {
    //         $query->where('min_age', '<=', $age)
    //             ->where('max_age', '>=', $age);
    //     })->first();

    //     return $membership;
    // }

}