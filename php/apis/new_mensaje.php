<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$id_user = $userData['IDuser'];
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if (isset($email)) {
    if ($_POST) {
        $id_user_destinatario = $_POST['id_usuario_destinatario'];
        $id_user_remitente = $_POST['id_usuario_remitente'];
        $mensaje_usuario = $_POST['mensaje'];
        $reservedWords = reservedWords();
        if (new_mensaje($id_user_destinatario, $id_user_remitente, $mensaje_usuario)) {
            $validate['success'] = true;
            $validate['message'] = 'Mensaje enviado correctamente';
        } else {
            header("HTTP/1.1 400 Bad Request"); // Bad Request
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El mensaje no se ha podido enviar';
        }
    }
} else {
    header("HTTP/1.1 401 Unauthorized"); // Unauthorized
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder enviar un ticket';
}
echo json_encode($validate);
