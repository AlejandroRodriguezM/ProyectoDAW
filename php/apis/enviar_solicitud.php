<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = getUserData($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
    $id_solicitante = $_POST['id_solicitante'];
    $id_destinatario = $_POST['id_destinatario'];
    if ($_POST) {
        if (enviar_solicitud($id_solicitante,$id_destinatario)) {
            $validate['success'] = true;
            $validate['message'] = 'Solicitud enviada';
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido enviar la solicitud';
        }
    }
} elseif ($userPrivilege == 'user') {
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}

echo json_encode($validate);
