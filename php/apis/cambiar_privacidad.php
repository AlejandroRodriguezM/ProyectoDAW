<?php
session_start(); // Inicia o reanuda una sesión en PHP.

include_once '../inc/header.inc.php'; // Incluye un archivo de cabecera común.

$email = $_SESSION['email']; // Obtiene el valor del correo electrónico del usuario almacenado en la variable de sesión.

$userData = obtener_datos_usuario($email); // Obtiene los datos del usuario basados en el correo electrónico.

$userPrivilege = $userData['privilege']; // Obtiene el privilegio del usuario basado en los datos obtenidos.

$validate['success'] = array('success' => false, 'message' => ""); // Inicializa un arreglo de validación con valores predeterminados.

if ($userPrivilege != 'guest') {
    // Verifica si el privilegio del usuario no es 'guest'.
    if ($_POST) {
        // Verifica si se ha enviado una solicitud POST.
        $email_user = $_POST['email'];
        $estado = filter_var($_POST['estado'], FILTER_VALIDATE_BOOLEAN);

        if (cambiar_privacidad($email_user, $estado)) {
            // Si la función cambiar_privacidad() devuelve true, se ha cambiado la privacidad de la cuenta.
            $validate['success'] = true;
            $validate['message'] = 'Tu cuenta ahora es privada';
            header("HTTP/1.1 200 OK"); // Se establece el código de respuesta HTTP a 200 (éxito).
        } else {
            // Si la función cambiar_privacidad() devuelve false, no se pudo cambiar la privacidad de la cuenta.
            $validate['success'] = true;
            $validate['message'] = 'Tu cuenta ahora es pública';
            header("HTTP/1.1 200 OK"); // Se establece el código de respuesta HTTP a 200 (éxito).
        }
    } else {
        // Si no se han recibido datos en la solicitud POST, se muestra un mensaje de error.
        header("HTTP/1.1 400 Bad Request"); // Se establece el código de respuesta HTTP a 400 (solicitud incorrecta).
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido modificar la privacidad';
    }
} else {
    // Si el privilegio del usuario es 'guest', se muestra un mensaje de error de falta de permisos.
    header("HTTP/1.1 401 Unauthorized"); // Se establece el código de respuesta HTTP a 401 (no autorizado).
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
}
header('Content-type: application/json');
echo json_encode($validate); // Se imprime el arreglo de validación como una respuesta JSON.
