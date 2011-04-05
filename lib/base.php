<?php

if (preg_match("/base\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Base {
  public $host = "http://mta.info"; /* MTA API base URL (there is no real base url...) | @var string */

  /**
   * Make an HTTP GET request
   *
   */    
  public function get($url = '', $params){
    $url = $this->host . $url;
    $data = simplexml_load_file($url);    
    // really brittle sorrrrrrrrry 
    if (strstr($url, "developers")) {      
      $xml = $this->parse_outages($data, $params);
    } else {
      $xml = $this->parse_train($data, $params);
    }    
    if (is_object($xml)){
      foreach($xml as $k => $v) {
        $this->{$k} = $v;
      }
      return $this;
    } else {
      return FALSE;
    }
  }

  public function parse_outages($data, $params) {    
    return (object) $data->outage;
  }

  public function parse_train($data, $train) {
    $train = (string) $train;
    $train = strtoupper($train);
    switch ($train) {
    case "1":  
    case "2":
    case "3":
      return (object) $data->subway->line[0];
    case "4":
    case "5":
    case "6":
      return (object) $data->subway->line[1];
    case "7":
      return (object) $data->subway->line[2];
    case "A":
    case "C":
    case "E":
      return (object) $data->subway->line[3];
    case "B":
    case "D":
    case "F":
    case "M":
      return (object) $data->subway->line[4];
    case "G":
      return (object) $data->subway->line[5];
    case "J":
    case "Z":
      return (object) $data->subway->line[6];
    case "L":
      return (object) $data->subway->line[7];
    case "N":
    case "Q": 
    case "R":
      return (object) $data->subway->line[8];
    case "S":
      return (object) $data->subway->line[9];
    case "SIR":
      return (object) $data->subway->line[9];
    default:
      return FALSE;
    }
  }
}