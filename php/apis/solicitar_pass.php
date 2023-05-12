<?php

session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $email = $_POST['email'];
    if (!obtener_datos_usuario($email)) {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. El usuario no existe';
    } else {
        if(solicitud_password($email)){
            header("HTTP/1.1 200 OK");
            $validate['success'] = true;
            $validate['message'] = 'Se ha enviado un correo a su cuenta de correo electrónico';
        }else{
            header("HTTP/1.1 404 Not Found");
            http_response_code(500); // Internal Server Error
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El usuario no existe';
        }
    }
}

echo json_encode($validate);
