<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializa el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

if ($_POST) {
    // Verifica si el usuario tiene los privilegios adecuados
    if ($userPrivilege == 'admin') {
        // Verifica si se ha enviado el formulario

        $email_user = $_POST['email'];
        $estado = filter_var($_POST['estado'], FILTER_VALIDATE_BOOLEAN);

        // Desautoriza o autoriza la cuenta de usuario según el estado recibido
        if (desautorizar_cuenta($email_user, $estado)) {
            $validate['success'] = true;
            $validate['message'] = 'Has bloqueado correctamente al usuario';
        } else {
            $validate['success'] = true;
            $validate['message'] = 'Has desbloqueado correctamente al usuario';
        }

        header("HTTP/1.1 200 OK");
    } else {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido desautorizar al usuario';
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido desautorizar al usuario';
}
header('Content-type: application/json');
// Devuelve la respuesta en formato JSON
echo json_encode($validate);
