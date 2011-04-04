<?php

if (preg_match("/base\.php$/", $_SERVER['PHP_SELF'])){
	exit('No direct script access allowed');
}

class Base {
  public $http_code; /* Last HTTP status code | @var string */
  public $url;  /* Last API call | @var string */
  public $host = "http://mta.info"; /* MTA API base URL (there is no real base url...) | @var string */
  public $timeout = 30; /* Timeout default | @var integer */
  public $connect_timeout = 30; /* Connect timeout default | @var integer */
  public $http_info; /* Lat HTTP headers | @var string */
  public $useragent = "Hyperpublic PHP beta"; /* Useragent string | @var string */
  public $ssl_verifypeer = FALSE; /* Verify SSL Cert? | @var boolean */

  public function parse_train($data, $train) {
    $train = (string) $train;
    switch($train) {
    case ("1" || "2" || "3"):  
      echo $data->subway->line->name[0];
      break;
    case ("4" || "5" || "6"):
      echo $data->subway->line->name[1];
      break;
    case "7":
      echo $data->subway->line->name[2];
      break;
    case ("A" || "C" || "E"):
      echo $data->subway->line->name[3];
      break;
    case ("B" || "D" || "F" || "M"):
      echo $data->subway->line->name[4];
      break;
    case "G":
      echo $data->subway->line->name[5];
      break;
    case ("J" || "Z"):
      echo $data->subway->line->name[6];
      break;
    case "L":
      echo $data->subway->line->name[7];
      break;
    case ("N" || "Q" || "R" ):
      echo $data->subway->line->name[8];
      break;
    case "S":
      echo $data->subway->line->name[9];
      break;
    case "SIR":
      echo $data->subway->line->name[9];
      break;
    }
  }
  /**
   * Make an HTTP GET request
   *
   */    
  public function get($url = '', $train){
    $url = $this->host . $url;
    $data = simplexml_load_file($url);
    $this->parse_train($data, $train);
    //    return $this;    
  }

    /* $url = $this->host . $url;
    $response = $this->http($url, 'GET');
    $response = json_decode($response);
    if (isset($response)){
      foreach ($response as $key => $value) {
        $this->{$key} = $value;
      }
      return $this;
    } else {
      return FALSE;
    }
  }
    */

  public function xml2array($xml) { 
    if(get_class($xml) != 'SimpleXMLElement') { 
      $xml = simplexml_load_string($xml); 
    } 
    if(!$xml) { 
      return false; 
    } 
    $main = $xml->getName(); 
    $arr  = array(); 
    $nodes = $xml->children(); 
    foreach($nodes as $node) { 
      $nodeName        = $node->getName(); 
      $nodeAttributes  = $node->attributes(); 
      $attributesArray = array(); 
      foreach($nodeAttributes as $attributeName => $attributeValue) { 
        $attributesArray[$attributeName] = (string) $attributeValue; 
      } 
      $nodeValue = sizeOf($node->children()) == 0 ? trim($node) : xml2array($node); 
      if(!isSet($arr[$nodeName]['value'])) { 
        $arr[$nodeName]['value']      = $nodeValue; 
        $arr[$nodeName]['attributes'] = $attributesArray; 
      } else { 
        if(!is_array($arr[$nodeName]['value'])) { 
          $arr[$nodeName]['value'][]      = array_shift($arr[$nodeName]); 
          $arr[$nodeName]['attributes'][] = array_shift($arr[$nodeName]['attributes']); 
        } 
        $arr[$nodeName]['value'][]      = $nodeValue; 
        $arr[$nodeName]['attributes'][] = $attributesArray; 
      } 
    } 
    return($arr); 
  } 


  /**
   * Make an HTTP request
   *
   * @return API results
   */
  function http($url = '', $method = '', $post_fields = NULL) {
    $this->http_info = array();
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
    curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
    curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
    curl_setopt($ci, CURLOPT_HEADER, FALSE);

    switch ($method) {
    case 'POST':
      curl_setopt($ci, CURLOPT_POST, TRUE);
      if (!empty($post_fields)) {
        curl_setopt($ci, CURLOPT_POST_FIELDS, $post_fields);
      }
      break;
    case 'DELETE':
      curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
      if (!empty($post_fields)) {
        $url = "{$url}?{$post_fields}";
      }
    }

    curl_setopt($ci, CURLOPT_URL, $url);
    $response = curl_exec($ci);
    $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
    $this->url = $url;
    curl_close ($ci);
    return $response;
  }

  /**
   * Get the header info to store.
   */
  function getHeader($ch, $header) {
    $i = strpos($header, ':');
    if (!empty($i)) {
      $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
      $value = trim(substr($header, $i + 2));
      $this->http_header[$key] = $value;
    }
    return strlen($header);
  }


}