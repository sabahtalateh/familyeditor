<?php
/**
 * Created by PhpStorm.
 * User: sabahtalateh
 * Date: 19/01/16
 * Time: 15:28
 */

namespace App\GenTree\Models;

use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property string family
 */
class EntitySet extends Eloquent
{
    /**
     * @var string
     */
    protected $table = 'entity_sets';
    /**
     * @var string
     */
    protected $setCol = 'set';

    /**
     * Insert new family
     *
     * @return mixed
     */
    public function getNewSet()
    {
        $this->setCol = Uuid::uuid();
        $this->save();
        return $this->id;
    }

    /**
     *  Clear unused values from EntitySet
     */
    public function clearTrash()
    {
        // TODO додавить возможность очистки несипользуемых записей
    }
}