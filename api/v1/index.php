<?php
error_reporting(E_ALL & ~E_NOTICE);

#Includes
include_once '../sos../sos_helper.php';
include_once '../dao../dao_usuario.php';
include_once '../dao../dao_comentario.php';

#Variables Globales
#$method = $_SERVER['REQUEST_METHOD'];
$entity = $_REQUEST['entity'];
$funcion = new funciones();

$arrJSON = array();

switch ($entity) {
   
  case 'usuario':
        
      $dao = new usuario();      
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
                   $insert =  $dao->registrarUsuario
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
              $arrParam2 = array('email'=>$_GET['email'],'password'=>$_GET['password']);
              $estado = $funcion->chkParmeters($arrParam2);
              
                if($estado!='ok'){
                  $funcion->setJsonResponse($estado, 400, 1);}
                else {                    
                    $arrJSON = $dao->listarUsuarioByEmail($_GET['email'],$_GET['password']);  
                   
                    if(!is_array($arrJSON))
                        {                            
                            $funcion->setJsonResponse($arrJSON, 500, 1);
                        }else
                            {
                                if ($arrJSON == NULL) {
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
          
  case 'comentario':
      
      $dao = new comentario();
      switch ($_SERVER['REQUEST_METHOD']) {
      
      #Metodo POST - Comentario
          case 'POST':
              $aKeys = array('usuario'=>$_POST['usuario'],'establecimiento'=>$_POST['establecimiento']);              
              $estado = $funcion->chkParmeters($aKeys);
              
              if($estado!='ok'){
                  $funcion->setJsonResponse($estado, 400, TRUE);
              }else{                                    
                   $insert =  $dao->insertarComentario($_POST['mensaje'], $aKeys['usuario'],$aKeys['establecimiento']);                                     
                        
                   switch ($insert['error_cod']) {                            
                             case 13.1:                                
                                $funcion->setJsonResponse($insert, 400, TRUE);
                                break;
                             case 13.2:                                
                                $funcion->setJsonResponse($insert, 500, TRUE);
                                break; 
                             default:
                                $arrJSON["message"]="Mensaje enviado!";
                                $funcion->setJsonResponse($arrJSON, 201, FALSE);
                                break;
                        }
              }
              break;            
              
          
      #Metodo GET - Comentario    
          case 'GET':
              $param = array('userID'=>$_GET['userID']);
              $estado = $funcion->chkParmeters($param);
              
                if($estado!='ok'){
                  $funcion->setJsonResponse($estado, 400, 1);}
                else {                    
                    $arrJSON = $dao->listarComentarioByUserID($_GET['userID']);
                   
                    if(!is_array($arrJSON))
                        {                            
                            $funcion->setJsonResponse($arrJSON, 500, 1);
                        }else
                            {
                                if ($arrJSON == NULL) {
                                    $arrJSON['message']='Oops!';
                                    $arrJSON['info']='Lo sentimos pero aun no tiene comentarios!';

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
      }#End Comentario
   
     break;
  
  case 'calificacion':
      
//      $dao = new comentario();
//      switch ($_SERVER['REQUEST_METHOD']) {
//      
//      #Metodo POST - Comentario
//          case 'POST':
//              $aKeys = array('usuario'=>$_POST['usuario'],'establecimiento'=>$_POST['establecimiento']);              
//              $estado = $funcion->chkParmeters($aKeys);
//              
//              if($estado!='ok'){
//                  $funcion->setJsonResponse($estado, 400, TRUE);
//              }else{                                    
//                   $insert =  $dao->registrarComentario($_POST['mensaje'], $aKeys['usuario'],$aKeys['establecimiento']);                                     
//                        
//                   switch ($insert['error_cod']) {                            
//                             case 13.1:                                
//                                $funcion->setJsonResponse($insert, 400, TRUE);
//                                break;
//                             case 13.2:                                
//                                $funcion->setJsonResponse($insert, 500, TRUE);
//                                break; 
//                             default:
//                                $arrJSON["message"]="Mensaje enviado!";
//                                $funcion->setJsonResponse($arrJSON, 201, FALSE);
//                                break;
//                        }
//              }
//              break;            
//              
//          
//      #Metodo GET - Comentario    
//          case 'GET':
//              $param = array('userID'=>$_GET['userID']);
//              $estado = $funcion->chkParmeters($param);
//              
//                if($estado!='ok'){
//                  $funcion->setJsonResponse($estado, 400, 1);}
//                else {                    
//                    $arrJSON = $dao->listarComentarioByID($_GET['userID']);
//                   
//                    if(!is_array($arrJSON))
//                        {                            
//                            $funcion->setJsonResponse($arrJSON, 500, 1);
//                        }else
//                            {
//                                if ($arrJSON == NULL) {
//                                    $arrJSON['message']='Oops!';
//                                    $arrJSON['info']='Lo sentimos pero aun no tiene comentarios!';
//
//                                    $funcion->setJsonResponse($arrJSON, 200, TRUE);
//                                }else
//                                {
//                                    $funcion->setJsonResponse($arrJSON, 200, FALSE);
//                                }
//                            }                                                         
//                }                        
//              break;
//              
//          default:
//              $aJSON['message']='Acceso denegado!';
//              $aJSON['info']='No se permiten otras peticiones';
//              $funcion->setJsonResponse($aJSON, 403, 1);
//              break;
//     }#End Calificacion
   
     break;
     
  default :
  echo 'Acceso denegado!';

}

?>
