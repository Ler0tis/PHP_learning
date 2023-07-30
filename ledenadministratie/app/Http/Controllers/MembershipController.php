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
}
