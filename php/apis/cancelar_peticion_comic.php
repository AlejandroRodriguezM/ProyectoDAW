<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];
$id_usuario = $userData['IDuser'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
    $id_comic = $_POST['id_comic'];
    $datos_peticion = info_peticiones_comics($id_comic);
    $id_peticion = $datos_peticion['id_peticion'];
    if(cambiar_estado_peticion($id_peticion)){
        $validate['success'] = true;
        $validate['message'] = 'Solicitud eliminada';
        header("HTTP/1.1 200 OK");
    }else{
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar la solicitud';
    }
}else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}

echo json_encode($validate);
