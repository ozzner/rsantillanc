<?php
error_reporting(E_ALL & ~E_NOTICE);

#Includes
include_once '../sos../sos_helper.php';
include_once '../dao../dao_usuario.php';

#Variables Globales
#$method = $_SERVER['REQUEST_METHOD'];
$entity = $_REQUEST['entity'];
$funcion = new funciones();
$daoUser = new usuario();
$arrJSON = array();

switch ($entity) {
   
  case 'usuario':
      
      switch ($_SERVER['REQUEST_METHOD']) {
      #Metodo POST - Usuario
          case 'POST':
              $arrParam = array('email'=>$_POST['email'],'sexo'=>$_POST['sexo'],'nombre'=>$_POST['nombre'],
                                'fecha'=>$_POST['fecha'],'apellido1'=>$_POST['apellido1'],'apellido2'=>$_POST['apellido2']);
              $estado = $funcion->chkParmeters($arrParam);
              
              if($estado!='ok'){
                  $funcion->setJsonResponse($estado, 400, 1);
              }else{
                   $insert =  $daoUser->registrar
                   ($arrParam['email'],$arrParam['sexo'], $arrParam['nombre'], $arrParam['fecha'], $arrParam['apellido1'], $arrParam['apellido2']);
                 
                    if ($insert=="Success!") {
                        $arrJSON["message"]="Usuario creado!";
                        $funcion->setJsonResponse($arrJSON, 201, FALSE);
                    }else{
                        $arrJSON["error"]=2;
                        $arrJSON["message"]="Error al registar!";
                        $arrJSON["info"]=$insert;
                        $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        }
              }
              break;            
              
      #Metodo GET - Usuario    
          case 'GET':
//              $arrParam2 = array('Id'=>$_GET['id']);
//              $estado = $funcion->chkParmeters($arrParam2);
//              
//                if($estado!='ok'){
//                  $funcion->setJsonResponse($estado, 400, 1);}
//       
                  
              break;
              
          default:
              break;
      }#End Usuario
   
     break;

 default :
    echo 'acceso denegado!';

}

?>
