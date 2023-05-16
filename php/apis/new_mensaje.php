<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario de la sesión
$email = $_SESSION['email'];

// Obtener los datos del usuario
$userData = obtener_datos_usuario($email);

// Obtener el ID de usuario y el privilegio del usuario
$id_user = $userData['IDuser'];
$userPrivilege = $userData['privilege'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

// Verificar si el correo electrónico está definido (el usuario está autenticado)
if (isset($email)) {
    if ($_POST) {
        $id_user_destinatario = $_POST['id_usuario_destinatario'];
        $id_user_remitente = $_POST['id_usuario_remitente'];
        $mensaje_usuario = $_POST['mensaje'];

        // Obtener las palabras reservadas del sistema
        $reservedWords = reservedWords();

        // Enviar el nuevo mensaje
        if (new_mensaje($id_user_destinatario, $id_user_remitente, $mensaje_usuario)) {
            $validate['success'] = true;
            $validate['message'] = 'Mensaje enviado correctamente';
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El mensaje no se ha podido enviar';
        }
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para poder enviar un mensaje';
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
