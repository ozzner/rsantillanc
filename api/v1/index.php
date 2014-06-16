<?php


#Includes
include_once '/';

$method = $_SERVER['REQUEST_METHOD'];


switch ($method) {
  case 'PUT':
    echo($method);
    break;
  case 'POST':
       echo($method);
    break;
  case 'GET':
      echo($method);
    break;
  case 'HEAD':
 echo($method);
    break;
  case 'DELETE':
     echo($method);
    break;
  case 'OPTIONS':
   echo($method);
    break;
  default:
 echo($method);
    break;
}

?>
