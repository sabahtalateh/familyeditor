<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('Add a child to parents');

$father = $I->addPerson('A', '', '', 1);
$mother = $I->addPerson('B', '', '', 0);
$child = $I->addPerson('C', '', '', 1);

$I->addChildToParents($father, $mother, $child);
$I->checkIfChildBeenAdded($father, $mother, $child);
$I->checkIfChildAndParentsAreInTheSameFamily($father, $mother, $child);

