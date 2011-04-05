<?php


error_reporting(E_ALL); 
ini_set("display_errors", 1); 

require_once('lib/sandhog.php');

$test = new Sandhog();

$stat = $test->service->status('b1');
echo "<br>";
echo $stat->status;
echo "<br>";
echo $stat->name;
echo $stat->plannedworkheadline;
echo "<br>";
//$a = $test->service->status('a');
//echo $a->status;
//echo $a->name;
//echo $a->plannedworkheadline;
echo "<br>";
$stat = $test->service->status('harlem');
echo "<br>";
echo $stat->status;
echo "<br>";
echo $stat->name;
echo $stat->plannedworkheadline;
echo "<br>";

$stat = $test->service->status('e');
echo "<br>";
echo $stat->status;
echo "<br>";
echo $stat->name;
echo $stat->plannedworkheadline;
echo "<br>";


$stat = $test->service->status('throgs neck');
echo "<br>";
echo $stat->status;
echo "<br>";
echo $stat->name;
echo $stat->plannedworkheadline;
echo "<br>";

//$outage = $test->outages->all(null);

//echo $outage->outage->station;
//echo "<br>";
//echo $outage->outage->serving;
