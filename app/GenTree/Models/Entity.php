<?php
namespace App\GenTree\Models;

use App\GenTree\Contracts\EntityContract;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int id
 * @property $this family_id
 */
class Entity extends Eloquent implements EntityContract
{
    /**
     * @var EntitySet
     */
    protected $set = EntitySet::class;

    /**
     * @var ClosureTable
     */
    protected $closure = ClosureTable::class;

    /**
     * @var string
     */
    protected $table = 'entities';


    /**
     * @var
     */
    protected $firstParentId;
    /**
     * @var
     */
    protected $secondParentId;

    /**
     * @var string
     */
    protected $idCol = 'id';

    /**
     * @var string
     */
    protected $levelCol = 'level';

    /**
     * @var string
     */
    protected $firstNameCol = 'first_name';

    /**
     * @var string
     */
    protected $lastNameCol = 'last_name';

    /**
     * @var string
     */
    protected $parentalCol = 'parental';

    /**
     * @var string
     */
    protected $genderCol = 'gender';

    /**
     * @var string
     */
    protected $firstParentCol = 'parent_id_1';

    /**
     * @var string
     */
    protected $secondParentCol = 'parent_id_2';

    /**
     * @var string
     */
    protected $setReferenceCol = 'set_id';

    /**
     * @return string
     */
    public function getIdCol()
    {
        return $this->idCol;
    }

    /**
     * @return string
     */
    public function getLevelCol()
    {
        return $this->levelCol;
    }

    /**
     * @return string
     */
    public function getFirstNameCol()
    {
        return $this->firstNameCol;
    }

    /**
     * @return string
     */
    public function getLastNameCol()
    {
        return $this->lastNameCol;
    }

    /**
     * @return string
     */
    public function getParentalCol()
    {
        return $this->parentalCol;
    }

    /**
     * @return string
     */
    public function getGenderCol()
    {
        return $this->genderCol;
    }

    /**
     * @return string
     */
    public function getFirstParentCol()
    {
        return $this->firstParentCol;
    }

    /**
     * @return string
     */
    public function getSecondParentCol()
    {
        return $this->secondParentCol;
    }

    /**
     * @return string
     */
    public function getSetReferenceCol()
    {
        return $this->setReferenceCol;
    }

    /**
     * @return mixed
     */
    private function getSet()
    {
        $setRefCol = $this->setReferenceCol;
        return $this->$setRefCol;
    }

    /**
     * Entity constructor.
     * Binding relations.
     */
    public function __construct()
    {
        parent::__construct();
        $this->closure = new $this->closure;
        $this->set = new $this->set;
    }

    /**
     * Setting handlers on save Entity
     */
    public static function boot()
    {
        parent::boot();

        parent::saving(function (Entity $entity) {
            if (!$entity->exists) {
                $entity->family_id = $entity->set->getNewSet();
            }
        });

        parent::created(function (Entity $entity) {
            $entity->closure->insertNode($entity->id);
        });
    }

    /**
     * Make child from current Entity and passed Parent ids
     *
     * @param $firstParentId
     * @param $secondParentId
     */
    public function makeChild($firstParentId, $secondParentId)
    {
        $this->firstParentId = $firstParentId;
        $this->secondParentId = $secondParentId;

        $this->releaseRelations();
        $this->addParents();
        $this->putEntitiesInSameSet();
    }

    /**
     *  Adding parents
     */
    private function addParents()
    {
        $this->closure->addParents($this->firstParentId, $this->secondParentId, $this->id);
        $this->parent_id_1 = $this->firstParentId;
        $this->parent_id_2 = $this->secondParentId;
        $this->save();
    }

    /**
     *  Release relations with this subtree
     */
    private function releaseRelations()
    {
        $this->closure->releaseRelations($this->id);
    }

    /**
     * Unused now but may be useful in future
     */
    private function putParentsInSameSet()
    {
        $table = $this->table;
        $setRefCol = $this->setReferenceCol;
        $firstParentSet = $this->find($this->firstParentId)->$setRefCol;
        $secondParentId = $this->secondParentId;

        $query = "
            UPDATE {$table} SET {$setRefCol} = {$firstParentSet} WHERE id = {$secondParentId}
        ";

        \DB::connection($this->connection)->update($query);
    }

    /**
     * Unused now but may be useful in future
     */
    private function putChildInTheParentsSet()
    {
        $table = $this->table;
        $setRefCol = $this->setReferenceCol;
        $firstParentSet = $this->find($this->firstParentId)->$setRefCol;
        $childId = $this->id;

        $query = "
            UPDATE {$table} SET {$setRefCol} = {$firstParentSet} WHERE id = {$childId}
        ";

        \DB::connection($this->connection)->update($query);
    }

    /**
     * Put Entity and it's Parents in same set
     */
    private function putEntitiesInSameSet()
    {
        $table = $this->table;
        $setRefCol = $this->setReferenceCol;
        $firstParentSet = $this->find($this->firstParentId)->$setRefCol;
        $secondParentSet = $this->find($this->secondParentId)->$setRefCol;
        $childSet = $this->$setRefCol;

        $query = "
            UPDATE {$table} SET {$setRefCol} = {$firstParentSet} WHERE {$setRefCol} IN ({$secondParentSet}, {$childSet})
        ";

        \DB::connection($this->connection)->update($query);
    }

    /**
     * @return mixed
     */
    public function buildRelationsTree()
    {
        $refCol = $this->setReferenceCol;
        return $this->closure->getRelationsForSet($this->$refCol);
    }
}