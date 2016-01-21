<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;

class PersonGenTreeController extends Controller
{
    public function show($personId)
    {
        $person = Person::find($personId);
        $tree = $person->buildRelationsTree();

        JavaScript::put([
            'gentree' => $tree,
            'currentElementId' => $personId
        ]);

        return view('person.gentree.show');
    }
}
