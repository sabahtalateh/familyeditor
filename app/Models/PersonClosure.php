<?php
namespace App\Models;


use App\GenTree\Models\ClosureTable;
use App\Models\Person;

class PersonClosure extends ClosureTable
{
    protected $table = 'person_closures';

    protected $entity = Person::class;
}