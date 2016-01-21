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
        $fatherId = $request->get('father');
        $motherId = $request->get('mother');

        // Check if persons in the same family
        $fathersFamily = Person::find($childId)->family_id;
        $mothersFamily = Person::find($fatherId)->family_id;
        $childFamily = Person::find($motherId)->family_id;

        if ($fathersFamily == $childFamily and $mothersFamily == $childFamily) {
            return \Redirect::back()->withErrors(['Потомок уже находится в одной семье с родителями']);
        }

        Person::find($childId)->makeChild($fatherId, $motherId);

        return \Redirect::route('person.gentree.show', $childId);
    }
}
