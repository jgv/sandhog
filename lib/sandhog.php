<?php 

if (preg_match("/sandhog\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Sandhog {

  public $train;
  public $outages;
  
  function __construct(){
    require_once(dirname(__FILE__) . '/base.php');
    require_once(dirname(__FILE__) . '/train.php');
    require_once(dirname(__FILE__) . '/outages.php');
    
    $this->train = new Train();
    $this->outages = new Outages();
  }
  
}