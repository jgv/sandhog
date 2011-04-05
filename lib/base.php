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
      $xml = $this->parse_service($data, $params);
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

  public function parse_service($data, $transpo) {
    $transpo = (string) $transpo;
    $transpo = strtoupper($transpo);
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
    case "B1":
    case "B83":
      return (object) $data->bus->line[0];
    case "B100":
    case "B103":
      return (object) $data->bus->line[1];
      break;
    case "BM1":
    case "BM5":
      return (object) $data->bus->line[2];
    case "BX1":
    case "BX55":
      return (object) $data->bus->line[3];
    case "BXM1":
    case "BXM18":
      return (object) $data->bus->line[4];
    case "M!":
    case "M116":
      return (object) $data->bus->line[5];
    case "N1":
    case "N88":
      return (object) $data->bus->line[6];
    case "Q1":
    case "Q113":
      return (object) $data->bus->line[7];
    case "QM1":
    case "QM25":
      return (object) $data->bus->line[8];
    case "S40":
    case "S98":
      return (object) $data->bus->line[9];
    case "X1":
    case "X68":
      return (object) $data->bus->line[10];
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
}