<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");

if ($userPrivilege != 'guest') {
    if ($_POST) {
        $id_user = $_POST['idUser'];
        $opinion = $_POST['opinion'];
        if (agregar_opinion_pagina($id_user, $opinion)) {
            $validate['success'] = true;
            $validate['message'] = 'Comentario en la pagina guardado correctamente';
            http_response_code(200);
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. La opinion no se ha guardado de forma correcta';
            http_response_code(500);
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha recibido ningun dato';
        http_response_code(400);
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder opinar';
    header("HTTP/1.1 500 Internal Server Error");
}

echo json_encode($validate);
