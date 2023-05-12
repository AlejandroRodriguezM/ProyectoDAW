<?php

session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $codigo_id = $_POST['id_activacion'];
    $pass = $_POST['pass'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    if (actualizar_password($codigo_id, $password)) {
        eliminar_codigo($codigo_id);
        header("HTTP/1.1 200 OK");
        $validate['success'] = true;
        $validate['message'] = 'Has recuperado tu contraseña';
    } else {
        header("HTTP/1.1 404 Not Found");
        http_response_code(500); // Internal Server Error
        $validate['success'] = false;
        $validate['message'] = 'ERROR. El usuario no existe';
    }
}

echo json_encode($validate);
