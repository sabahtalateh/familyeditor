<?php
namespace App\GenTree\Models;

use App\GenTree\Contracts\ClosureTableContract;
use DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class ClosureTable
 * @package App\GenTree\Models
 */
class ClosureTable extends Eloquent implements ClosureTableContract
{
    /**
     * @var
     */
    protected $entity = Entity::class;

    /**
     * @var string
     */
    protected $table = 'entity_closures';

    /**
     * @var string
     */
    protected $personCol = 'person_id';
    /**
     * @var string
     */
    protected $firstAncestorCol = 'ancestor_id_1';
    /**
     * @var string
     */
    protected $secondAncestorCol = 'ancestor_id_2';
    /**
     * @var string
     */
    protected $levelCol = 'level';

    /**
     * ClosureTable constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Inserting new node
     * @param $elementId
     */
    public function insertNode($elementId)
    {
        if (!is_numeric($elementId)) {
            throw new \InvalidArgumentException('arguments must be of type int.');
        }

        $table = $this->getTable();
        $personCol = $this->personCol;
        $firstAncestorCol = $this->firstAncestorCol;
        $secondAncestorCol = $this->secondAncestorCol;

        $query = "
            INSERT INTO {$table} ({$personCol}, {$firstAncestorCol}, {$secondAncestorCol})
            VALUE ({$elementId}, {$elementId}, {$elementId})
        ";

        DB::connection($this->connection)->insert($query);
    }

    /**
     * Release node's relations
     *
     * @param $nodeId
     */
    public function releaseRelations($nodeId)
    {
        $table = $this->getTable();
        $personCol = $this->personCol;
        $firstAncestorCol = $this->firstAncestorCol;
        $secondAncestorCol = $this->secondAncestorCol;

        $query = "
            SELECT {$personCol}
            FROM {$table}
            WHERE ({$secondAncestorCol} = {$nodeId} OR {$firstAncestorCol} = {$nodeId})
        ";

        $relationsList = DB::connection($this->connection)->select($query);
        $relations = '';
        array_walk($relationsList, function ($i) use (&$relations) {
            $relations .= ($i->person_id) . ",";
        });
        $relations = rtrim($relations, ",");

        $query = "
            DELETE FROM {$table}
            WHERE person_id IN ({$relations})
            AND ({$secondAncestorCol} NOT IN ({$relations}) OR {$firstAncestorCol} NOT IN ({$relations}));
        ";

        DB::connection($this->connection)->delete($query);
    }

    /**
     * @param $fatherId
     * @param $motherId
     * @param $childId
     */
    public function addParents($fatherId, $motherId, $childId)
    {
        $parents = array_unique([$fatherId, $motherId]);

        foreach ($parents as $parent) {
            $this->moveNode($parent, $childId);
        }
    }

    /**
     * @param $parentId
     * @param $childId
     */
    private function moveNode($parentId, $childId)
    {
        $table = $this->getTable();
        $personCol = $this->personCol;
        $firstAncestorCol = $this->firstAncestorCol;
        $secondAncestorCol = $this->secondAncestorCol;
        $levelCol = $this->levelCol;

        $query = "
            INSERT INTO {$table} (
              {$secondAncestorCol},
              {$firstAncestorCol},
              {$personCol},
              {$levelCol}
            )
              SELECT
                supertree.{$secondAncestorCol},
                supertree.{$firstAncestorCol},
                subtree.{$personCol},
                supertree.{$levelCol} + subtree.{$levelCol} + 1
              FROM {$table} AS supertree JOIN {$table} AS subtree
              WHERE (subtree.{$secondAncestorCol} = {$childId} OR subtree.{$firstAncestorCol} = {$childId})
                    AND supertree.{$personCol} = {$parentId}
          ";

        DB::connection($this->connection)->insert($query);
    }

    /**
     * Get all Entities in passed EntitySet with theirs relations
     *
     * @param $setId
     * @return mixed
     */
    public function getRelationsForSet($setId)
    {
        $entity = new $this->entity;
        $entityTable = $entity->getTable();
        $entityIdCol = $entity->getIdCol();
        $entityLevelCol = $entity->getLevelCol();
        $entityFirstNameCol = $entity->getFirstNameCol();
        $entityLastNameCol = $entity->getLastNameCol();
        $entityParentalCol = $entity->getParentalCol();
        $entityGenderCol = $entity->getGenderCol();
        $entityFirstParentCol = $entity->getFirstParentCol();
        $entitySecondParentCol = $entity->getSecondParentCol();
        $entitySetRef = $entity->getSetReferenceCol();

        $personCol = $this->personCol;
        $table = $this->getTable();

        $query = "
            SELECT
              MAX({$entityLevelCol}) AS {$entityLevelCol},
              {$entityTable}.{$entityIdCol},
              {$entityTable}.{$entityFirstNameCol},
              {$entityTable}.{$entityLastNameCol},
              {$entityTable}.{$entityParentalCol},
              {$entityTable}.{$entityGenderCol},
              {$entityTable}.{$entityFirstParentCol},
              {$entityTable}.{$entitySecondParentCol}
            FROM {$table}
              JOIN {$entityTable} ON {$entityTable}.{$entityIdCol} = {$table}.{$personCol}
            WHERE {$entityTable}.{$entitySetRef} = $setId
            GROUP BY {$personCol}";

        $r = DB::connection($this->connection)->select($query);

        return json_decode(json_encode($r), true, 2048);
    }
}