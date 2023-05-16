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
        $id_comic = $_POST['idComic'];
        $opinion = $_POST['opinion'];
        $puntuacion = $_POST['puntuacion'];

        // Agregar la opinión del usuario sobre el cómic
        if (agregar_opinion($id_user, $id_comic, $opinion, $puntuacion)) {
            $validate['success'] = true;
            $validate['message'] = 'La opinión se ha guardado correctamente';
            http_response_code(200);
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. La opinión no se ha guardado correctamente';
            http_response_code(500);
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. La opinión no se ha guardado en la base de datos';
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
