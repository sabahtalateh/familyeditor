<?php
namespace App\Models;


use App\GenTree\Models\ClosureTable;
use App\GenTree\Models\Entity;

/**
 * @property mixed first_name
 * @property mixed last_name
 * @property mixed parental
 * @property mixed gender
 */
class Person extends Entity
{
    protected $table = 'persons';

    protected $fillable = [
        'first_name',
        'last_name',
        'parental',
        'gender',
        'family_id'
    ];

    protected $closure = PersonClosure::class;
    protected $set = Family::class;
    public $setReferenceCol = 'family_id';
}