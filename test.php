<?php


error_reporting(E_ALL); 
ini_set("display_errors", 1); 

require_once('lib/sandhog.php');

$sandhog = new Sandhog();


$train = $sandhog->service->status('b4');