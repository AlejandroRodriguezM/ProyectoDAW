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
    if ($userPrivilege == 'admin') {

        // Obtener los datos del usuario a eliminar desde el formulario
        $id_user = $_POST['id_user'];
        $email = $_POST['emailUser'];

        // Eliminar al usuario según su correo electrónico y ID
        if (eliminar_usuario($email, $id_user)) {
            $validate['success'] = true;
            $validate['message'] = 'Usuario borrado correctamente';
            header("HTTP/1.1 200 OK");
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido eliminar al usuario';
            header("HTTP/1.1 500 Internal Server Error");
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar la lista';
        header("HTTP/1.1 400 Bad Request");
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido eliminar la lista';
    header("HTTP/1.1 401 Unauthorized");
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
