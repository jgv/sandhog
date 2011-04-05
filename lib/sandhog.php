<?php 

if (preg_match("/sandhog\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Sandhog {

  public $service;
  public $outages;
  
  function __construct(){
    require_once(dirname(__FILE__) . '/base.php');
    require_once(dirname(__FILE__) . '/service.php');
    require_once(dirname(__FILE__) . '/outages.php');
    
    $this->service = new Service();
    $this->outages = new Outages();
  }
  
}