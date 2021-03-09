<?php

include 'classes/DB.php';
include 'classes/Country.php';
include 'classes/Layout.php';

//Fetch Data
$world = new DB();
$continents = $world->getContinents();

//Validate User's Request
$userContinent = (in_array($_REQUEST['Continent'], $continents )) ? $_REQUEST['Continent'] : '';
$userSort = (in_array($_REQUEST['Sort'], ['Population', 'Name', 'LifeExpectancy']))? $_REQUEST['Sort'] : '';

//Fetch Countries
$countries = $world->getCountries($userContinent, $userSort);

//Build Page Layout. Pass along data.
$page = new Layout($continents, $countries, $userContinent, $userSort);

$page->header();
$page->banner();
$page->navigation();
$page->sortUI();
$page->grid();
$page->footer();

//close database conneciton.
$world->end();

?>
