<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = getUserData($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
    if ($_POST) {
        $email_user = $_POST['email'];
        $estado = $_POST['estado'];
        if (cambiar_privacidad($email_user, $estado)) {
            $validate['success'] = true;
            if ($estado == 'true') {
                $validate['message'] = 'Tu cuenta ahora es privada';
            } elseif ($estado == 'false') {
                $validate['message'] = 'Tu cuenta ahora es publica';
            }
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido modificar la privacidad';
        }
    }
} elseif ($userPrivilege == 'user') {
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}

echo json_encode($validate);
