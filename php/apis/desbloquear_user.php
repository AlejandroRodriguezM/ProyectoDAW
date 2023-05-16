<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializa el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

// Verifica si el usuario tiene los privilegios adecuados
if ($userPrivilege != 'guest') {
    $id_solicitante = $_POST['id_solicitante'];
    $id_destinatario = $_POST['id_destinatario'];

    // Verifica si se ha enviado el formulario
    if ($_POST) {
        // Desbloquea al usuario destinatario según el solicitante
        if (desbloquear_usuario($id_destinatario, $id_solicitante)) {
            $validate['success'] = true;
            $validate['message'] = 'Has desbloqueado al usuario';
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido desbloquear al usuario';
        }
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}
header('Content-type: application/json');
// Devuelve la respuesta en formato JSON
echo json_encode($validate);
