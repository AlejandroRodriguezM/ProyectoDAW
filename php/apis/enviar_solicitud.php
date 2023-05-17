<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario activo y sus datos
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");


if ($_POST) {
    // Verificar los privilegios del usuario y procesar la solicitud
    if ($userPrivilege != 'guest') {
        // Obtener los datos del formulario
        $id_solicitante = $_POST['id_solicitante'];
        $id_destinatario = $_POST['id_destinatario'];

        // Enviar la solicitud
        if (enviar_solicitud($id_solicitante, $id_destinatario)) {
            $validate['success'] = true;
            $validate['message'] = 'Solicitud enviada';
            header("HTTP/1.1 200 OK");
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido enviar la solicitud';
            header("HTTP/1.1 500 Internal Server Error");
        }
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
    header("HTTP/1.1 401 Unauthorized");
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
