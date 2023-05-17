<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario activo y sus datos
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

$id_comentario = $_POST['id_comentario'];

// Verificar si se ha enviado el formulario
if ($_POST) {
    // Verificar los privilegios del usuario y procesar la solicitud
    if ($userPrivilege != 'guest') {

        // Eliminar el comentario de la página según el ID proporcionado
        if (eliminar_comentario_pagina($id_comentario)) {
            $validate['success'] = true;
            $validate['message'] = 'El comentario se ha eliminado correctamente';
            header("HTTP/1.1 200 OK");
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido eliminar el comentario';
            header("HTTP/1.1 500 Internal Server Error");
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar el comentario';
        header("HTTP/1.1 400 Bad Request");
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido eliminar el comentario';
    header("HTTP/1.1 401 Unauthorized");
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
