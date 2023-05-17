<?php
session_start();
include_once '../inc/header.inc.php';

// Obtiene el correo electrónico del usuario de la sesión
$email = $_SESSION['email'];

// Obtiene los datos del usuario
$userData = obtener_datos_usuario($email);
$id_user = $userData['IDuser'];
$userPrivilege = $userData['privilege'];

// Inicializa el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    // Verifica si el correo electrónico está definido
    if (isset($email)) {
        // Verifica si se ha enviado el formulario

        // Obtiene los datos del formulario
        $id_usuario_denunciado = $_POST['id_usuario_denunciado'];
        $id_usuario_denunciante = $_POST['id_usuario_denunciante'];
        $mensaje_usuario = $_POST['mensaje'];
        $motivo_denuncia = $_POST['motivo_denuncia'];

        // Obtiene las palabras reservadas
        $reservedWords = reservedWords();

        // Verifica si el mensaje contiene palabras reservadas
        if (in_array(strtolower($mensaje_usuario), $reservedWords)) {
            header("HTTP/1.1 400 Bad Request"); // Bad Request
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El mensaje contiene palabras reservadas';
        } else {
            // Crea una nueva denuncia
            if (nueva_denuncia($id_usuario_denunciado, $id_usuario_denunciante, $mensaje_usuario, $motivo_denuncia)) {
                $validate['success'] = true;
                $validate['message'] = 'Denuncia enviada correctamente';
            } else {
                header("HTTP/1.1 400 Bad Request"); // Bad Request
                $validate['success'] = false;
                $validate['message'] = 'ERROR. No se ha podido enviar la denuncia';
            }
        }
    } else {
        header("HTTP/1.1 400 Bad Request"); // Bad Request
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido enviar la denuncia';
    }
} else {
    header("HTTP/1.1 401 Unauthorized"); // Unauthorized
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido enviar la denuncia';
}
header('Content-type: application/json');
// Devuelve la respuesta en formato JSON
echo json_encode($validate);
