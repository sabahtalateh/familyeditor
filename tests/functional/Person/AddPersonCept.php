<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('Correctly add a new person');

$person = $I->addPerson('Иван', 'Жожев', 'Петрович', 1);

$I->canSeeInPersons($person);
$I->canSeeInClosuresJustOnTime($person);
