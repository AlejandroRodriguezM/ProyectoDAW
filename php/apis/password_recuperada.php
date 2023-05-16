<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $codigo_id = $_POST['id_activacion'];
    $pass = $_POST['pass'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    // Actualizar la contraseña del usuario
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

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
