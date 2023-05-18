<?php

session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $email = $_POST['email'];
    if (!check_email_user($email)) {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. El usuario no existe';
    } else {
        if (solicitud_password($email)) {
            header("HTTP/1.1 200 OK");
            $validate['success'] = true;
            $validate['message'] = 'Se ha enviado un correo a su cuenta de correo electrónico';
        } else {
            header("HTTP/1.1 404 Not Found");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El usuario no existe';
            http_response_code(500); // Internal Server Error

        }
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido enviar el correo';
}
header('Content-type: application/json');
echo json_encode($validate);
