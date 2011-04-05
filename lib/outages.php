<?php

if (preg_match("/escalator\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Outages extends Base {

  public $all;
  public $NYCOutages;
  public $responsecode;
  public $message;
  public $outage;
  public $station;
  public $borough;
  public $trainno;
  public $equipment;
  public $equipmenttype;
  public $serving;
  public $ADA;
  public $outagedate;
  public $estimatedreturntoservice;
  public $reason;
  public $isupcomingoutage;
  public $ismaintenanceoutage;
  public $endpoint = "/developers/data/nyct/nyct_ene.xml";


  public function all($station){
    $this->get($this->endpoint, $station);
    return $this;
  }
  
}











