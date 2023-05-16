<?php
session_start(); // Inicia o reanuda una sesión en PHP.

include_once '../inc/header.inc.php'; // Incluye un archivo de cabecera común.

$email = $_SESSION['email']; // Obtiene el valor del correo electrónico del usuario almacenado en la variable de sesión.

$userData = obtener_datos_usuario($email); // Obtiene los datos del usuario basados en el correo electrónico.

$id_usuario = $userData['IDuser']; // Obtiene el ID de usuario basado en los datos obtenidos.

$userPrivilege = $userData['privilege']; // Obtiene el privilegio del usuario basado en los datos obtenidos.

$validate['success'] = array('success' => false, 'message' => ""); // Inicializa un arreglo de validación con valores predeterminados.

if ($userPrivilege != 'guest') {
    // Verifica si el privilegio del usuario no es 'guest'.
    if ($_POST) {
        // Verifica si se ha enviado una solicitud POST.
        $id_conversacion = $_POST['id_conversacion'];

        cambiar_estado_mensajes($id_conversacion, $id_usuario);
        // Llama a la función cambiar_estado_mensajes() con los parámetros proporcionados.

    } else {
        // Si no se han recibido datos en la solicitud POST, se muestra un mensaje de error.
        header("HTTP/1.1 400 Bad Request"); // Se establece el código de respuesta HTTP a 400 (solicitud incorrecta).
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se han recibido los datos';
    }
} else {
    // Si el privilegio del usuario es 'guest', se muestra un mensaje de error de falta de permisos.
    header("HTTP/1.1 401 Unauthorized"); // Se establece el código de respuesta HTTP a 401 (no autorizado).
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder modificar una lista';
}
header('Content-type: application/json');
echo json_encode($validate); // Se imprime el arreglo de validación como una respuesta JSON.
