<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
    if ($_POST) {
        $id_user = $_POST['idUser'];
        $asunto_ticket = $_POST['asunto_ticket'];
        $descripcion_ticket = $_POST['mensaje'];
        $estado = 'Abierto';
        $reservedWords = reservedWords();
        $fecha = date('Y-m-d H:i:s');
        $fechaCreacion = date('Y-m-d', strtotime(str_replace('-', '/', $fecha)));
        if (in_array(strtolower($asunto_ticket), $reservedWords) || in_array(strtolower($descripcion_ticket), $reservedWords)) {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. You cannot use system reserved words';
        } else {
            if (new_ticket($id_user, $asunto_ticket, $descripcion_ticket, $fecha, $estado)) {
                $validate['success'] = true;
                $validate['message'] = 'El ticket se ha enviado correctamente';
            } else {
                header("HTTP/1.1 400 Bad Request"); // Bad Request
                $validate['success'] = false;
                $validate['message'] = 'ERROR. El ticket no se ha podido enviar';
            }
        }
    }
} else {
    header("HTTP/1.1 401 Unauthorized"); // Unauthorized
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder enviar un ticket';
}
echo json_encode($validate);
