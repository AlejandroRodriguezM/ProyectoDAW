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

if ($_POST) {
    // Verificar si el privilegio del usuario no es 'guest'
    if ($userPrivilege != 'guest') {

        $id_user = $_POST['idUser'];
        $asunto_ticket = $_POST['asunto_ticket'];
        $descripcion_ticket = $_POST['mensaje'];
        $estado = 'Abierto';

        // Obtener las palabras reservadas del sistema
        $reservedWords = reservedWords();

        // Obtener la fecha actual
        $fecha = date('Y-m-d H:i:s');
        $fechaCreacion = date('Y-m-d', strtotime(str_replace('-', '/', $fecha)));

        // Verificar si el asunto o la descripción del ticket contienen palabras reservadas
        if (in_array(strtolower($asunto_ticket), $reservedWords) || in_array(strtolower($descripcion_ticket), $reservedWords)) {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. You cannot use system reserved words';
        } else {
            // Crear el nuevo ticket
            if (new_ticket($id_user, $asunto_ticket, $descripcion_ticket, $fecha, $estado)) {
                $validate['success'] = true;
                $validate['message'] = 'El ticket se ha enviado correctamente';
            } else {
                header("HTTP/1.1 400 Bad Request");
                $validate['success'] = false;
                $validate['message'] = 'ERROR. El ticket no se ha podido enviar';
            }
        }
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para poder enviar un ticket';
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
