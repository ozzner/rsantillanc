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
              $aKeys = array(
                  'email'=>$_POST['email'],'sexo'=>$_POST['sexo'],'nombre'=>$_POST['nombre'],'password'=>$_POST['password'],
                  'fecha'=>$_POST['fecha'],'apellido1'=>$_POST['apellido1'],'apellido2'=>$_POST['apellido2']);
              
              $estado = $funcion->chkParmeters($aKeys);
              
              if($estado!='ok'){
                  $funcion->setJsonResponse($estado, 400, TRUE);
              }else{                                    
                   $insert =  $daoUser->registrar
                   ($aKeys['email'],$aKeys['sexo'], $aKeys['nombre'], $aKeys['fecha'], $aKeys['apellido1'], $aKeys['apellido2'],$aKeys['password']);
                   
                        switch ($insert['error_cod']) {
                            
                             case 11.1:                                
                                $funcion->setJsonResponse($insert, 500, TRUE);
                                break;
                             case 11.2:
                                $funcion->setJsonResponse($insert, 500, TRUE);
                                break;
                             case 11.3:
                                $funcion->setJsonResponse($insert, 500, TRUE);
                                break;
                             default:
                                $arrJSON["message"]="Usuario creado!";
                                $funcion->setJsonResponse($arrJSON, 201, FALSE);
                                break;
                                          }
              }
              break;            
              
          
      #Metodo GET - Usuario    
          case 'GET':
              $arrParam2 = array('email'=>$_GET['email'],'pass'=>$_GET['password']);
              $estado = $funcion->chkParmeters($arrParam2);
              
                if($estado!='ok'){
                  $funcion->setJsonResponse($estado, 400, 1);}
                else {                    
                    $arrJSON = $daoUser->listarByIdApiKey($_GET['email'],$_GET['password']);  
                   
                    if(!is_array($arrJSON))
                        {                            
                            $funcion->setJsonResponse($arrJSON, 500, 1);
                        }else
                            {
                                if ($arrJSON==NULL) {
                                    $arrJSON['message']='Invalido';
                                    $arrJSON['info']='Dato inexistente!';

                                    $funcion->setJsonResponse($arrJSON, 200, TRUE);
                                }else
                                {
                                    $funcion->setJsonResponse($arrJSON, 200, FALSE);
                                }
                            }                                                         
                }                        
              break;
              
          default:
              $aJSON['message']='Acceso denegado!';
              $aJSON['info']='No se permiten otras peticiones';
              $funcion->setJsonResponse($aJSON, 403, 1);
              break;
      }#End Usuario
   
     break;

 default :
    echo 'Acceso denegado!';

}

?>
