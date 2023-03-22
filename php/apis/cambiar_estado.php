<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = getUserData($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest' && $userPrivilege != 'user') {
    if ($_POST) {
        $email_user = $_POST['email'];
        $estado = $_POST['estado'];
        if (changeStatusAccount($email_user, $estado)) {
            $validate['success'] = true;
            if ($estado == 'true') {
                $validate['message'] = 'Has bloqueado correctamente al usuario';
            } elseif ($estado == 'false') {
                $validate['message'] = 'Has desbloqueado correctamente al usuario';
            } else {
                $validate['message'] = 'Has desactivado correctamente tu usuario';
            }
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido bloquear al usuario';
        }
    }
} elseif ($userPrivilege == 'user') {
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}

echo json_encode($validate);
