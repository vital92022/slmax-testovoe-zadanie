<?php

require_once "PeopleDB.php";
require_once "ListPeople.php";


$c1 = new PeopleDB("Vitalia", "Bur", "1999-09-28", "1", "Gomel");
$c2 = new PeopleDB(2);
//$c2->__construct("nami", "sure", "septebdre", 1, "Gomel");
//var_dump($c1);
//$c2->name = "eeee";
//$c2->sex = 1;
//$c2->savePerson();
//$c2->deletePerson();

//var_dump($c2);

//PeopleDB::sexSwith($c2);
//$x = $c2->formattingPerson();
//PeopleDB::findOutAge($c2);
//var_dump($c2);
//echo "\n\n///////////////////////////////////////////";
//var_dump($x);
//echo $c1->getId();

$arr = new ListPeople();
var_dump($arr->getArrayPeople($arr->arrId));
$arr->deleteArray2($arr->getArrayPeople($arr->arrId));
//$arr->getArrayPeople($arr->arrId);
//var_dump($arr->arrPip);
//var_dump($arr);

?>
