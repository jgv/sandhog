<?php

if (preg_match("/train\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Train extends Base {

  public $endpoint = "/status/serviceStatus.txt";

    function status($train){
      $this->get($this->endpoint, $train);      
      return $this;
    }
  
}