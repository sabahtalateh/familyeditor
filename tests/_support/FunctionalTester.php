<?php
use App\Models\Person;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * Define custom actions here
     * @param $firstName
     * @param $lastName
     * @param $parental
     * @param $gender
     * @return Person
     */
    public function addPerson($firstName, $lastName, $parental, $gender)
    {
        $person = new Person();
        $person->first_name = $firstName;
        $person->last_name = $lastName;
        $person->parental = $parental;
        $person->gender = $gender;
        $person->save();

        return $person;
    }

    public function canSeeInPersons(Person $person)
    {
        $this->assertTrue($person->exists());
    }

    public function canSeeInClosuresJustOnTime(Person $person)
    {
        $closures = \App\Models\PersonClosure::where([
            'person_id' => $person->id,
            'ancestor_id_1' => $person->id,
            'ancestor_id_2' => $person->id
        ]);

        $this->assertEquals(1, $closures->count());
    }

    public function addChildToParents(Person $father, Person $mother, Person $child)
    {
        $child->makeChild($father->id, $mother->id);
    }

    public function checkIfChildBeenAdded(Person $father, Person $mother, Person $child)
    {
        $child = (Person::find($child->id));

        $childParentIds = [$child->parent_id_1, $child->parent_id_2];
        sort($childParentIds);
        $parentIdsPassed = [$father->id, $mother->id];
        sort($parentIdsPassed);

        $this->assertEquals($childParentIds, $parentIdsPassed);
    }

    public function checkIfChildAndParentsAreInTheSameFamily(Person $father, Person $mother, Person $child)
    {
        $fathersFamily = Person::find($father->id)->family_id;
        $mothersFamily = Person::find($mother->id)->family_id;
        $childFamily = Person::find($child->id)->family_id;

        $families = array_unique([$fathersFamily, $mothersFamily, $childFamily]);
        $this->assertEquals(1, count($families));
    }
}
