<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario activo y sus datos
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

// Verificar los privilegios del usuario y procesar la solicitud
if ($userPrivilege != 'guest') {
    // Verificar si se ha enviado el formulario
    if ($_POST) {
        // Obtener el ID de la lista y el ID del usuario desde el formulario
        $id_lista = $_POST['id_lista'];
        $id_user = $_POST['id_user'];

        // Eliminar la lista según los IDs proporcionados
        if (eliminar_lista($id_lista, $id_user)) {
            $validate['success'] = true;
            $validate['message'] = 'La lista se ha eliminado correctamente';
            header("HTTP/1.1 200 OK");
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido eliminar la lista';
            header("HTTP/1.1 500 Internal Server Error");
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar la lista';
        header("HTTP/1.1 400 Bad Request");
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para poder eliminar una lista';
    header("HTTP/1.1 401 Unauthorized");
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
