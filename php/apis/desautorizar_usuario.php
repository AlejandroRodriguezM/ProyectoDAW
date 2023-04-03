<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest' && $userPrivilege != 'user') {
    if ($_POST) {
        $email_user = $_POST['email'];
        $estado = filter_var($_POST['estado'], FILTER_VALIDATE_BOOLEAN);
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
        $validate['message'] = 'ERROR. No se ha podido bloquear al usuario';
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}

echo json_encode($validate);
