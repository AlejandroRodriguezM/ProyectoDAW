<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario desde la sesión
$email = $_SESSION['email'];

// Obtener los datos del usuario
$userData = obtener_datos_usuario($email);

// Obtener el privilegio del usuario
$userPrivilege = $userData['privilege'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

// Verificar si el usuario no es un invitado
if ($userPrivilege != 'guest') {
    // Verificar si se ha enviado una solicitud POST
    if ($_POST) {
        // Obtener los datos del formulario
        $id_user = $_POST['id_user'];
        $id_comic = $_POST['id_comic'];

        // Guardar el cómic para el usuario especificado
        if (guardar_comic($id_user, $id_comic)) {
            $validate['success'] = true;
            header("HTTP/1.1 200 OK");
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido guardar el cómic';
            header("HTTP/1.1 500 Internal Server Error");
        }
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para poder guardar un cómic';
    header("HTTP/1.1 401 Unauthorized");
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
