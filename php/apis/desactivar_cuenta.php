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
    // Verifica si se ha enviado el formulario
    if ($_POST) {
        $email_user = $_POST['email'];

        // Desactiva la cuenta de usuario
        if (desactivar_cuenta($email_user)) {
            $validate['success'] = true;
            $validate['message'] = 'Has desactivado correctamente tu usuario';
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido desactivar tu usuario';
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
