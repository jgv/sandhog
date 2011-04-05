<?php

if (preg_match("/train\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Service extends Base {

  public $status;
  public $service;
  public $name; 
  public $text;
  public $plannedworkheadline;
  public $endpoint = "/status/serviceStatus.txt";

    function status($transpo){
      $this->get($this->endpoint, $transpo);
      return $this;
    }
  
}