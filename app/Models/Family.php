<?php
/**
 * Created by PhpStorm.
 * User: sabahtalateh
 * Date: 19/01/16
 * Time: 15:32
 */

namespace App\Models;


use App\GenTree\Models\EntitySet;

class Family extends EntitySet
{
    protected $table = 'families';
    protected $setCol = 'family';
}