<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario activo y sus datos
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];
$id_usuario = $userData['IDuser'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

// Verificar los privilegios del usuario y procesar la solicitud
if ($userPrivilege != 'guest') {
    // Obtener el ID del cómic desde el formulario
    $id_comic = $_POST['id_comic'];

    // Obtener los datos de la petición del cómic
    $datos_peticion = info_peticiones_comics($id_comic);
    $id_peticion = $datos_peticion['id_peticion'];

    // Eliminar la petición del cómic según el ID de la petición
    if (eliminar_peticion_comic($id_peticion)) {
        $validate['success'] = true;
        $validate['message'] = 'Solicitud eliminada';
        header("HTTP/1.1 200 OK");
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar la solicitud';
        header("HTTP/1.1 500 Internal Server Error");
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
    header("HTTP/1.1 401 Unauthorized");
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
