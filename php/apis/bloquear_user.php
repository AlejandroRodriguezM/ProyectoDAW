<?php
session_start(); // Inicia o reanuda una sesión en PHP.

include_once '../inc/header.inc.php'; // Incluye un archivo de cabecera común.

$email = $_SESSION['email']; // Obtiene el valor del correo electrónico del usuario almacenado en la variable de sesión.

$userData = obtener_datos_usuario($email); // Obtiene los datos del usuario basados en el correo electrónico.

$userPrivilege = $userData['privilege']; // Obtiene el privilegio del usuario basado en los datos obtenidos.

$validate['success'] = array('success' => false, 'message' => ""); // Inicializa un arreglo de validación con valores predeterminados.

if ($_POST) {
    if ($userPrivilege != 'guest') {
        // Verifica si el privilegio del usuario no es 'guest'.
        $id_solicitante = $_POST['id_solicitante'];
        $id_destinatario = $_POST['id_destinatario'];


        // Verifica si se ha enviado una solicitud POST.
        if (bloquear_usuario($id_destinatario, $id_solicitante)) {
            // Si la función bloquear_usuario() devuelve true, se bloquea al usuario.
            $validate['success'] = true;
            $validate['message'] = 'Has bloqueado al usuario';
            header("HTTP/1.1 200 OK"); // Se establece el código de respuesta HTTP a 200 (éxito).
        } else {
            // Si la función bloquear_usuario() devuelve false, no se puede bloquear al usuario.
            header("HTTP/1.1 400 Bad Request"); // Se establece el código de respuesta HTTP a 400 (solicitud incorrecta).
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido bloquear al usuario';
        }
    } else {
        // Si el privilegio del usuario es 'guest', se muestra un mensaje de error de falta de permisos.
        header("HTTP/1.1 401 Unauthorized"); // Se establece el código de respuesta HTTP a 401 (no autorizado).
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No tienes permisos para realizar esta acción';
    }
} else {
    // Si no se ha enviado una solicitud POST, se muestra un mensaje de error de solicitud incorrecta.
    header("HTTP/1.1 400 Bad Request"); // Se establece el código de respuesta HTTP a 400 (solicitud incorrecta).
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido bloquear al usuario';
}
header('Content-type: application/json');
echo json_encode($validate); // Se imprime el arreglo de validación como una respuesta JSON.
