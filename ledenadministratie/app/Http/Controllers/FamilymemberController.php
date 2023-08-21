<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Membership;
use App\Models\Contribution;
use App\Models\Familymember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



class FamilymemberController extends Controller
{

    // Show familymember create form
    public function create($family_id = null) {
        return view('familymembers.create', compact('family_id'));
    }

    // Store familymember data
    public function store(Request $request, Familymember $familymember)
    {
        $dataFields = $request->validate(Familymember::rules());

        $dateOfBirth = \DateTime::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

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

        // // Haal het ingevoerde kortingspercentage op
        // $discountPercentage = $request->discount_percentage / 100;

        // $baseAmount = 100; // Het basisbedrag van €100

        // // Bereken het bedrag na toepassing van het ingevoerde kortingspercentage
        // $calculatedAmount = $baseAmount - ($baseAmount * $discountPercentage);

        // Koppel het juiste lidmaatschap aan de familymember
        $membership = $this->selectMembership($request->input('date_of_birth'));
        $familyMember->membership()->associate($membership);

        $familyMember->save();

        // // Creëer een nieuwe Contribution record
        // $contribution = new Contribution([
        //     'membership_id' => $membership->id,
        //     'amount' => $calculatedAmount,
        // ]);

        // $familyMember->contribution()->save($contribution);

        return redirect('/')->with('message', 'Familymember is successfully added.');
    }



    // Show edit form for Family members and the memberships from DB
    public function edit(Familymember $familymember) {
        // Retrieve all available memberships
        $memberships = Membership::all();
        
        return view('familymembers.edit', compact('familymember', 'memberships'));
    }


    public function update(Request $request, Familymember $familymember)
    {
        $dataFields = $request->validate(Familymember::rules($familymember));

        $dataFields['date_of_birth'] = Carbon::createFromFormat('d-m-Y', $request->input('date_of_birth'))->format('Y-m-d');

        // If a membership is selected, associate it with the family member
        if ($request->has('membership_id')) {
            $familymember->membership()->associate($request->input('membership_id'));
        } else {
            // If no membership is selected, remove any existing association
            $familymember->membership()->dissociate();
        }

        $familymember->update($dataFields);

        return redirect('/')->with('success', 'Familielid succesvol bijgewerkt!');
    }
        //HANDMATIG URL AANMAKEN EN REDIRECTEN (WERKT)
        //return redirect('/families/' . $familymember->family_id)->with('message', 'Familymember updated!');

    public function destroy($id)
    {
        $familyMember = Familymember::findOrFail($id);
        $familyMember->delete();
        
        return redirect('/')->with('message', 'Familymember is succesfully deleted');
    }

    public function selectMembership($dateOfBirth)
    {
        $birthDate = Carbon::createFromFormat('d-m-Y', $dateOfBirth);
        $currentDate = Carbon::now();

        $age = $birthDate->diffInYears($currentDate);

        $membership = Membership::whereHas('contribution', function ($query) use ($age) {
            $query->where('min_age', '<=', $age)
                ->where('max_age', '>=', $age);
        })->first();

        return $membership;
    }

}
