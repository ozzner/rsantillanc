<?php

error_reporting(E_ALL & ~E_NOTICE);

#Includes
include_once '/home/appradec/public_html/api/sos/sos_helper.php';
include_once '/home/appradec/public_html/api/dao/dao_usuario.php';
include_once '/home/appradec/public_html/api/dao/dao_comentario.php';
include_once '/home/appradec/public_html/api/dao/dao_calificacion.php';
include_once '/home/appradec/public_html/api/dao/dao_categoria.php';
include_once '/home/appradec/public_html/api/dao/dao_distrito.php';
include_once '/home/appradec/public_html/api/dao/dao_establecimiento.php';
include_once '/home/appradec/public_html/api/dao/dao_ranking.php';
include_once '/home/appradec/public_html/api/dao/dao_coordenadas.php';
require '../vendor/Slim/Slim.php';

//include_once '../sos../sos_helper.php';
//include_once '../dao../dao_usuario.php';
//include_once '../dao../dao_comentario.php';
//include_once '../dao../dao_calificacion.php';
//include_once '../dao../dao_categoria.php';
//include_once '../dao../dao_distrito.php';
//include_once '../dao../dao_establecimiento.php';
//include_once '../dao../dao_ranking.php';
//include_once '../dao../dao_coordenadas.php';
#Variables Globales
$method = $_SERVER['REQUEST_METHOD'];
$entity = $_REQUEST['entity'];
$funcion = new funciones();
$arrJSON = array();

#inicializing slim
\Slim\Slim::registerAutoloader();
$app = new Slim\Slim();

switch ($entity) {

    case 'usuario':

        $dao = new usuario();
        switch ($method) {

            #Metodo POST - Usuario
            case 'POST':
                $aKeys = array(
                    'email' => $_POST['email'], 'sexo' => $_POST['sexo'], 'nombre' => $_POST['nombre'], 'password' => $_POST['password'],
                    'fecha' => $_POST['fecha']);

                $estado = $funcion->chkParmeters($aKeys);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $insert = $dao->registrarUsuario
                            ($aKeys['email'], $aKeys['sexo'], $aKeys['nombre'], $aKeys['fecha'], $aKeys['apellido1'], $aKeys['apellido2'], $aKeys['password']);

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
                            $arrJSON["message"] = "Usuario creado!";
                            $funcion->setJsonResponse($arrJSON, 201, FALSE);
                            break;
                    }
                }
                break;


            #Metodo GET - Usuario    
            case 'GET':
                $arrParam2 = array('email' => $_GET['email'], 'password' => $_GET['password'], 'controller' => $_GET['controller']);
                $estado = $funcion->chkParmeters($arrParam2);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $arrJSON = $dao->login($_GET['email'], $_GET['password'], $_GET['controller']);

                    if (!is_array($arrJSON)) {
                        $funcion->setJsonResponse($arrJSON, 500, TRUE);
                    } else {

                        if ($arrJSON == NULL) {
                            $arrJSON['message'] = 'Invalido';
                            $arrJSON['info'] = 'Dato inexistente!';

                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        } else {

                            if ($arrJSON['error_cod'] > 0) {
                                $funcion->setJsonResponse($arrJSON, 200, TRUE);
                            }
                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                        }
                    }
                }
                break;

            default:
                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'No se permiten otras peticiones';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
                break;
        }#End Usuario

        break;

    case 'comentario':

        $dao = new comentario();
        switch ($method) {

            #Metodo POST - Comentario
            case 'POST':
                $aKeys = array('usuarioID' => $_POST['usuarioID'], 'establecimientoID' => $_POST['establecimientoID']);
                $estado = $funcion->chkParmeters($aKeys);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $insert = $dao->insertarComentario($_POST['mensaje'], $aKeys['usuarioID'], $aKeys['establecimientoID']);

                    switch ($insert['error_cod']) {
                        case 13.1:
                            $funcion->setJsonResponse($insert, 400, TRUE);
                            break;
                        case 13.2:
                            $funcion->setJsonResponse($insert, 500, TRUE);
                            break;
                        default:
                            $arrJSON["message"] = "Mensaje enviado!";
                            $funcion->setJsonResponse($arrJSON, 201, FALSE);
                            break;
                    }
                }
                break;


            #Metodo GET - Comentario    
            case 'GET':

                $param = array('establecimientoID' => $_GET['establecimientoID']);
                $estado = $funcion->chkParmeters($param);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $arrJSON = $dao->listarComentariosByID($_GET['establecimientoID']);

                    if (!is_array($arrJSON)) {
                        $funcion->setJsonResponse($arrJSON, 500, TRUE);
                    } else {
                        if ($arrJSON == NULL) {
                            $arrJSON['message'] = 'Oops!';
                            $arrJSON['info'] = 'Error, no se pudo listar los comentarios.';

                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        } else {
                            if ($arrJSON['error_cod'] > 0) {
                                $funcion->setJsonResponse($arrJSON, 200, TRUE);
                            }
                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                        }
                    }
                }

                break;

            default:
                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'No se permiten otras peticiones';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
                break;
        }#End Comentario

        break;

    case 'calificacion':

        $dao = new calificacion();
        switch ($method) {

            #Metodo POST - Calificacion
            case 'POST':
                $aKeys = array('usuario' => $_POST['usuario'], 'establecimiento' => $_POST['establecimiento'], 'cola' => $_POST['cola']);
                $estado = $funcion->chkParmeters($aKeys);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $insert = $dao->insertarCalificacion($_POST['usuario'], $_POST['establecimiento'], $_POST['cola']);

                    switch ($insert['error_cod']) {
                        case 14.1:
                            $funcion->setJsonResponse($insert, 400, TRUE);
                            break;
                        case 14.2:
                            $funcion->setJsonResponse($insert, 500, TRUE);
                            break;
                        default:
                            $arrJSON["message"] = "¡Calificacion exitosa!";
                            $funcion->setJsonResponse($arrJSON, 201, FALSE);
                            break;
                    }
                }
                break;


            #Metodo GET - Calificacion    
            case 'GET':
                $param = array('establecimientoID' => $_GET['establecimientoID']);
                $estado = $funcion->chkParmeters($param);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $arrJSON = $dao->listarCalificacionByEstablishmentID($_GET['establecimientoID']);

                    if (!is_array($arrJSON)) {
                        $funcion->setJsonResponse($arrJSON, 500, TRUE);
                    } else {
                        if ($arrJSON == NULL) {
                            $arrJSON['message'] = 'OK';
                            $arrJSON['info'] = 'No hay cola';

                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        } else {
                            if ($arrJSON['error_cod'] > 0) {
                                $funcion->setJsonResponse($arrJSON, 200, TRUE);
                            }
                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                        }
                    }
                }
                break;

            default:
                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'No se permiten otras peticiones';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
                break;
        }#End Calificacion

        break;

    case 'categoria':

        $dao = new categoria();
        switch ($method) {

            #Metodo GET - Categoria    
            case 'GET':
                $param = array('categoriaID' => $_GET['categoriaID']);
                $estado = $funcion->chkParmeters($param);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $arrJSON = $dao->listarCategoriaByID($_GET['categoriaID']);

                    if (!is_array($arrJSON)) {
                        $funcion->setJsonResponse($arrJSON, 500, TRUE);
                    } else {
                        if ($arrJSON == NULL) {
                            $arrJSON['message'] = 'Oops!';
                            $arrJSON['info'] = 'No hay categoria!';

                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        } else {
                            if ($arrJSON['error_cod'] > 0) {
                                $funcion->setJsonResponse($arrJSON, 200, TRUE);
                            }
                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                        }
                    }
                }
                break;

            default:
                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'No se permiten otras peticiones';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
                break;
        }#End Categoria

        break;

    case 'ranking':

        $dao = new ranking();
        switch ($method) {

            #Metodo GET - Ranking    
            case 'GET':
                $param = array('rankingID' => $_GET['rankingID']);
                $estado = $funcion->chkParmeters($param);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $arrJSON = $dao->listarRankingByID($_GET['rankingID']);

                    if (!is_array($arrJSON)) {
                        $funcion->setJsonResponse($arrJSON, 500, TRUE);
                    } else {
                        if ($arrJSON == NULL) {
                            $arrJSON['message'] = 'Oops!';
                            $arrJSON['info'] = 'No hay un ranking con ese ID!';

                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        } else {
                            if ($arrJSON['error_cod'] > 0) {
                                $funcion->setJsonResponse($arrJSON, 200, TRUE);
                            }
                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                        }
                    }
                }
                break;

            default:
                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'No se permiten otras peticiones';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
                break;
        }#End Ranking
        break;

    case 'coordenadas':

        $dao = new coordenadas();
        switch ($method) {

            #Metodo GET - Coordenadas    
            case 'GET':
                $param = array('coordenadasID' => $_GET['coordenadasID']);
                $estado = $funcion->chkParmeters($param);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $arrJSON = $dao->listarCoordendasByID($_GET['coordenadasID']);

                    if (!is_array($arrJSON)) {
                        $funcion->setJsonResponse($arrJSON, 500, TRUE);
                    } else {
                        if ($arrJSON == NULL) {
                            $arrJSON['message'] = 'Oops!';
                            $arrJSON['info'] = 'No se encontro las coordenadas con ese ID!';

                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        } else {
                            if ($arrJSON['error_cod'] > 0) {
                                $funcion->setJsonResponse($arrJSON, 200, TRUE);
                            }
                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                        }
                    }
                }
                break;

            default:
                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'No se permiten otras peticiones';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
                break;
        }#End Coordenadas
        break;

    case 'distrito':

        $dao = new distrito();
        switch ($method) {

            #Metodo GET - Distrito    
            case 'GET':
                $param = array('distritoID' => $_GET['distritoID']);
                $estado = $funcion->chkParmeters($param);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {
                    $arrJSON = $dao->listarDistritoByID($_GET['distritoID']);

                    if (!is_array($arrJSON)) {
                        $funcion->setJsonResponse($arrJSON, 500, TRUE);
                    } else {
                        if ($arrJSON == NULL) {
                            $arrJSON['message'] = 'Oops!';
                            $arrJSON['info'] = 'No se encontro distrito, verificar valores!';

                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                        } else {
                            if ($arrJSON['error_cod'] > 0) {
                                $funcion->setJsonResponse($arrJSON, 200, TRUE);
                            }
                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                        }
                    }
                }
                break;

            default:
                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'No se permiten otras peticiones';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
                break;
        }#End Distrito
        break;

    case 'establecimiento':

        $dao = new establecimiento();
        switch ($method) {

            #Metodo GET - Establecimiento    
            case 'GET':

                $param = array('tag' => $_GET['tag']);
                $estado = $funcion->chkParmeters($param);

                if ($estado != 'ok') {
                    $funcion->setJsonResponse($estado, 400, TRUE);
                } else {

                    $tag = $_GET['tag'];

                    switch ($tag) {

                        case "categoryID":

                            $param = array('categoryID' => $_GET['categoryID']);
                            $estado = $funcion->chkParmeters($param);

                            if ($estado != 'ok') {
                                $funcion->setJsonResponse($estado, 400, TRUE);
                            } else {

                                $arrJSON = $dao->listEstablishmentByCategoryID($_GET['categoryID']);

                                if (!is_array($arrJSON)) {
                                    $funcion->setJsonResponse($arrJSON, 500, TRUE);
                                } else {

                                    if ($arrJSON == NULL) {
                                        $arrJSON['message'] = 'Oops!';
                                        $arrJSON['info'] = 'No se encontro el establecimiento, verificar valores!';

                                        $funcion->setJsonResponse($arrJSON, 200, TRUE);
                                    } else {

                                        if ($arrJSON['error_cod'] > 0) {
                                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                                        } else {
                                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                                        }
                                    }
                                }
                            }



                            break;
                        case "name":

                            $param = array('name' => $_GET['name']);
                            $estado = $funcion->chkParmeters($param);

                            if ($estado != 'ok') {
                                $funcion->setJsonResponse($estado, 400, TRUE);
                            } else {
                                $arrJSON = $dao->listEstablishmentByName($_GET['name']);

                                if (!is_array($arrJSON)) {
                                    $funcion->setJsonResponse($arrJSON, 500, TRUE);
                                } else {

                                    if ($arrJSON == NULL) {
                                        $arrJSON['message'] = 'Oops!';
                                        $arrJSON['info'] = 'No se encontro el establecimiento, verificar valores!';

                                        $funcion->setJsonResponse($arrJSON, 200, TRUE);
                                    } else {

                                        if ($arrJSON['error_cod'] > 0) {
                                            $funcion->setJsonResponse($arrJSON, 200, TRUE);
                                        } else {
                                            $funcion->setJsonResponse($arrJSON, 200, FALSE);
                                        }
                                    }
                                }
                            }




                            break;

                        default:
                            break;
                    }
                }

                break;
            case 'POST':

                $aJSON['message'] = 'Acceso denegado!';
                $aJSON['info'] = 'Contacte con el administrador admin@admin.com';
                $funcion->setJsonResponse($aJSON, 403, TRUE);
        }#End Establecimiento
        break;

    default :

        $app->post('/establishments', function () use ($app, $dao, $funcion) {

            $dao = new establecimiento();
            $param = array(
                'direccion' => $_REQUEST['direccion'],
                'nombre' => $_REQUEST['nombre'],
                'estado' => $_REQUEST['estado'],
                'cat_id' => $_REQUEST['cat_id'],
                'dis_id' => $_REQUEST['dis_id'],
                'latitude' => $_REQUEST['latitude'],
                'longitude' => $_REQUEST['longitude']);

            $estado = $funcion->chkParmeters($param);
            if ($estado != 'ok') {
                $funcion->setJsonResponse($estado, 400, TRUE);
            } else {

                $direccion = $app->request->post('direccion');
                $nombre = $app->request->post('nombre');
                $status = $app->request->post('estado');
                $catID = $app->request->post('cat_id');
                $disID = $app->request->post('dis_id');
                $latitide = $app->request->post('latitude');
                $longitude = $app->request->post('longitude');
                $ruc = 10458688350; #My ruc.

                $result = $dao->storeEstablishmentFromUser(
                        $direccion, $nombre, $ruc, $status, $catID, $disID, $latitide, $longitude);
                if ($result > 1) {

                    $arrJSON['message'] = '¡Muchas gracias!';
                    $arrJSON['info'] = 'Creado correctamente.';
                    $funcion->setJsonResponse($arrJSON, 201, FALSE);
                } else {
                    $arrJSON['message'] = 'Error';
                    $arrJSON['info'] = 'Informe. ' . $result;
                    $funcion->setJsonResponse($arrJSON, 400, TRUE);
                }
            }
        });
} //End switch
//
#Slim RUN
$app->run();
?>
