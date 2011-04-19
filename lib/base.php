<?php

if (preg_match("/base\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Base {
  public $host = "http://mta.info"; /* MTA API base URL (there is no real base url...) | @var string */

  /**
   * Make an HTTP GET request and return some data
   *
   */    
  public function get($url = '', $transpo){
    $url = $this->host . $url;
    $data = simplexml_load_file($url);        
    $xml = $this->parse_service($data, $transpo);
    if (is_object($xml)){
      foreach($xml as $k => $v) {
        $this->{$k} = strip_tags($v);
      }
      return $this;
    } else {
      return FALSE;
    }
  }

  /**
   *
   * Parse data if param is a bus
   *
   * $data simplexml object
   * $transpo string
   */
  public function bus($data, $transpo) {
    // B1 - B103
    if (preg_match("/^[B]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"B");
      if ($bus >= 1 and $bus <= 103 ) {
        return (object) $data->bus->line[0];
      } elseif ($bus >= 100 and $bus <= 103) {    
        return (object) $data->bus->line[1];
      } else {
        return false;
      }
    }
    // BM1 - BM5
    if (preg_match("/^[BM]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"BM");
      if ($bus >= 1 and $bus <= 5){
        return (object) $data->bus->line[2];
      } else {
        return false;
      }
    }
    // BX1 - BX55
    if (preg_match("/^[BX]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"BX");
      if ($bus >= 1 and $bus <= 55) {
        return (object) $data->bus->line[3];
      }
    }
    // BXM1 - BXM18
    if (preg_match("/^[BXM]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"BXM");
      if ($bus >= 1 and $bus <= 18) {
        return (object) $data->bus->line[4];
      }
    }
    // M1 - M116
    if (preg_match("/^[M]\d+/", $transpo, $match)){
      $bus = trim($match[0],"M");
      if ($bus >= 1 and $bus <= 116) {
        return (object) $data->bus->line[5];
      }
    }
    // N1 - N88
    if (preg_match("/^[N]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"N");
      if ($bus >= 1 and $bus <= 88) {
        return (object) $data->bus->line[6];
      }
    }
    // Q1 - Q113
    if (preg_match("/^[Q]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"Q");
      if ($bus >= 1 and $bus <= 113) {
        return (object) $data->bus->line[7];
      }
    }
      // QM1 - QM25
    if (preg_match("/^[QM]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"QM");
      if ($bus >= 1 and $bus <= 25) {
        return (object) $data->bus->line[8];
      }
    }
    // S40 - S98
    if (preg_match("/^[S]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"S");
      if ($bus >= 40 and $bus <= 98) {
        return (object) $data->bus->line[9];
      }
    }
    // X1 - X68
    if (preg_match("/^[X]\d+/", $transpo, $match)) {
      $bus = trim($match[0],"X");
      if ($bus >= 10 and $bus <= 68) {
        return (object) $data->bus->line[10];
      }
    }
  }

  /**
   *
   * Parse data if a subway
   * $data simplexml object
   * $transpo string
   *
   */
  public function subway($data, $transpo){
    switch ($transpo) {
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
      return (object) $data->subway->line[10];
    }
  }
  
  /**
   *
   * Parse data if a bridge, tunnel, LIRR, or MetroNorth
   * $data simplexml object
   * $transpo $string
   *
   */
  public function bridgeTunnel($data,$transpo){
    switch ($transpo) {
    case "THROGS NECK":
      return (object) $data->BT->line[0];
    case "HENRY HUDSON":
      return (object) $data->BT->line[1];
    case "MARINE PARKWAY":
      return (object) $data->BT->line[2];
    case "BRONX-WHITESTONE":
      return (object) $data->BT->line[3];
    case "BROOKLYN-BATTERY":
      return (object) $data->BT->line[4];
    case "QUEENS MIDTOWN":
      return (object) $data->BT->line[5];
    case "ROBERT F. KENNEDY":
      return (object) $data->BT->line[6];      
    case "CROSS BAY":
      return (object) $data->BT->line[7];
    case "VERRAZANO-NARROWS":
      return (object) $data->BT->line[8];
    case "CITY TERMINAL ZONE":
      return (object) $data->LIRR->line[0];
    case "BABYLON":
      return (object) $data->LIRR->line[1];
    case "FAR ROCKAWAY":
      return (object) $data->LIRR->line[2];
    case "HEMPSTEAD":
      return (object) $data->LIRR->line[3];
    case "LONG BEACH":
      return (object) $data->LIRR->line[4];
    case "MONTAUK":
      return (object) $data->LIRR->line[5];
    case "OYSTER BAY":
      return (object) $data->LIRR->line[6];
    case "PORT JEFFERSON":
      return (object) $data->LIRR->line[7];
    case "PORT WASHINGTON":
      return (object) $data->LIRR->line[8];
    case "RONKONKOMA":
      return (object) $data->LIRR->line[9];
    case "WEST HEMPSTEAD":
      return (object) $data->LIRR->line[9];
    case "HUDSON":
      return (object) $data->MetroNorth->line[0];
    case "HARLEM":
      return (object) $data->MetroNorth->line[1];
    case "WASAIC":
      return (object) $data->MetroNorth->line[2];
    case "NEW HAVEN":
      return (object) $data->MetroNorth->line[3];
    case "NEW CANAAN":
      return (object) $data->MetroNorth->line[4];
    case "DANBURY":
      return (object) $data->MetroNorth->line[5];
    case "WATERBURY":
      return (object) $data->MetroNorth->line[6];
    case "PASCACK VALLEY":
      return (object) $data->MetroNorth->line[7];
    case "PORT JARVIS":
      return (object) $data->MetroNorth->line[8];
    default:
      return FALSE;
    }
  }

  /**
   *
   * Figure out where to send the data
   * $data simplexml object
   * $transpo string
   *
   */

  public function parse_service($data, $transpo) {
    $transpo = (string) $transpo;
    $transpo = strtoupper($transpo);
    if (strlen($transpo) > 3) {
      return $this->bridgeTunnel($data, $transpo);
    } elseif ( strlen($transpo) == 1 || strpos($transpo, "SIR") != false ) {
      return $this->subway($data, $transpo);      
    } else {
      return $this->bus($data, $transpo);
    }
  }

}