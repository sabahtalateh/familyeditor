<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('home');
});


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the 'web' middleware group to every route
| it contains. The 'web' middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('person/create', ['uses' => 'PersonController@create', 'as' => 'person.create']);
    Route::post('person', ['uses' => 'PersonController@store', 'as' => 'person.store']);

    Route::get('person/relation/create', ['uses' => 'PersonRelationsController@create', 'as' => 'person.relations.create']);

    Route::get('person/children/create', ['uses' => 'PersonChildrenController@create', 'as' => 'person.children.create']);
    Route::post('person/children', ['uses' => 'PersonChildrenController@store', 'as' => 'person.children.store']);
    Route::get('person/list', ['uses' => 'PersonController@getList', 'as' => 'person.list']);

    Route::get('gentree/{person_id}', ['uses' => 'PersonGenTreeController@show', 'as' => 'person.gentree.show']);

    Route::get('api/persons/{query}/{gender?}', "api\\PersonsController@index");
});
