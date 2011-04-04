<?php


error_reporting(E_ALL); 
ini_set("display_errors", 1); 

require_once('lib/sandhog.php');

$test = new Sandhog();

$stat = $test->train->status('L');

//print_r($stat);

//print_r($test->train->status('L'));