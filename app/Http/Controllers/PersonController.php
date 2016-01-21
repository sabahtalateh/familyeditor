<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class PersonController extends Controller
{
    public function create()
    {
        return view('person.create');
    }

    public function store(Requests\StorePersonRequest $request)
    {
        $person = new Person();
        $person->first_name = $request->get('first_name');
        $person->last_name = $request->get('last_name');
        $person->parental = $request->get('parental');
        $person->gender = $request->get('gender');
        $person->save();

        flash()->success('Вы добавили ' . $person->first_name);
        return Redirect::route('person.list');
    }

    public function getList(Person $person)
    {
        $persons = $person->orderBy('id','desc')->paginate(10);
        return view('person.list', ['persons' => $persons]);
    }
}
