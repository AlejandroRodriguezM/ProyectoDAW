<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_usuario = $userData['IDuser'];
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
    if ($_POST) {
        $id_conversacion = $_POST['id_conversacion'];

        cambiar_estado_mensajes($id_conversacion, $id_usuario);

    } else {
        header("HTTP/1.1 400 Bad Request"); // Bad Request
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se han recibido los datos';
    }
} else {
    header("HTTP/1.1 401 Unauthorized"); // Unauthorized
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder modificar una lista';
}
echo json_encode($validate);
