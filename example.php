<?php


error_reporting(E_ALL); 
ini_set("display_errors", 1); 

require_once('lib/sandhog.php');

$test = new Sandhog();

$stat = $test->train->line('g');
echo "<br>";
echo $stat->status;
echo $stat->name;
echo $stat->plannedworkheadline;
echo "<br>";
$a = $test->train->line('a');
echo $a->status;
echo $a->name;
echo $a->plannedworkheadline;
echo "<br>";

$outage = $test->outages->all(null);

echo $outage->outage->station;
echo "<br>";
echo $outage->outage->serving;
