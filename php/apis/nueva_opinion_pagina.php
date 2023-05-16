<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario de la sesión
$email = $_SESSION['email'];

// Obtener los datos del usuario
$userData = obtener_datos_usuario($email);

// Obtener el privilegio del usuario
$userPrivilege = $userData['privilege'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

// Verificar si el privilegio del usuario no es 'guest'
if ($userPrivilege != 'guest') {
    if ($_POST) {
        $id_user = $_POST['idUser'];
        $opinion = $_POST['opinion'];

        // Agregar la opinión a la página
        if (agregar_opinion_pagina($id_user, $opinion)) {
            $validate['success'] = true;
            $validate['message'] = 'Comentario en la página guardado correctamente';
            http_response_code(200);
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. La opinión no se ha guardado de forma correcta';
            http_response_code(500);
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha recibido ningún dato';
        http_response_code(400);
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para poder opinar';
    http_response_code(500);
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
