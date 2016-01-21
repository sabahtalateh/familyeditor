<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PersonChildrenController extends Controller
{
    public function create()
    {
        return view('person.children.create');
    }

    public function store(Requests\StorePersonChildrenRequest $request)
    {
        $childId = $request->get('child');
        Person::find($childId)->makeChild($request->get('father'), $request->get('mother'));

        return \Redirect::route('person.gentree.show', $childId);
    }
}
