<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_denuncia = $_POST['id_denuncia'];
    $id_admin = $_POST['id_admin'];
    $id_usuario = $_POST['id_usuario'];
    $respuesta_mensaje = $_POST['mensaje'];
    $reservedWords = reservedWords();

    if (in_array(strtolower($respuesta_mensaje), $reservedWords)) {
        http_response_code(400);
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (respuesta_denuncia($id_denuncia,$id_admin,$id_usuario,$respuesta_mensaje)) {

            $validate['success'] = true;
            $validate['message'] = 'El ticket se ha respondido correctamente';
        } else {
            http_response_code(500);
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El ticket no se ha respondido correctamente';
        }
    }
} else {
    http_response_code(400);
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The ticket data was not provided in the request';
}
header('Content-type: application/json');
echo json_encode($validate);
