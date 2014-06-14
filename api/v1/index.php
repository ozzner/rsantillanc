<?php
echo 'hello ozzner';

$mail = $_POST['correo'];
$sex = $_POST['sexo'];
$nom = $_POST['nombre'];
$feh = $_POST['fecha'];
$app = $_POST['apellido1'];
$apm = $_POST['apellido2'];



include_once '../dao../dao_usuario.php';

$usuario = new usuario();
$respuesta = $usuario->registrar($mail, $sex, $nom, $feh, $app, $apm);

echo 'Esta es la respuesta: '.$respuesta;
?>
