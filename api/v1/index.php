<?php

#Includes
include_once '../sos../sos_helper.php';
include_once '../dao../dao_usuario.php';

#Variables Globales
$method = $_SERVER['REQUEST_METHOD'];
$entity;
$arrEcho = array();

switch ($method) {
    
  case 'PUT':
    echo($method);
    break;
  case 'POST':
  
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
