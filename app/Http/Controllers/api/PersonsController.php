<?php

namespace App\Http\Controllers\api;

use DB;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PersonsController extends Controller
{
    public function index($query, $gender = null)
    {
        $params = (explode(' ', $query));
        $newQuery = '';
        array_walk($params, function ($param) use (&$newQuery) {
            $newQuery .= '%' . $param . '% ';
        });
        $newQuery = rtrim($newQuery, ' ');

        $builder = DB::table('persons');
        if ($gender != null) {
            $builder = \App\Models\Person::where('gender', $gender);
        }
        $builder->whereRaw("concat_ws(' ', last_name, first_name, parental) LIKE '{$newQuery}'");

        return $builder->get();
    }
}
