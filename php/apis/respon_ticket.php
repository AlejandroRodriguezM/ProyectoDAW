<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $ticket_id = $_POST['ticket_id'];
    $mensaje_ticket = $_POST['mensaje'];
    $estado = $_POST['estado'];
    $usuario_id = $_POST['user_id'];
    $email = $_SESSION['email'];
    $user_dato = obtener_datos_usuario($email);
    $nombre_admin = $user_dato['userName'];
    $reservedWords = reservedWords();
    $fecha = date('Y-m-d H:i:s');
    $row = obtener_datos_usuario($usuario_id);
    $privilegio = $row['privilege'];
    if (in_array(strtolower($mensaje_ticket), $reservedWords)) {
        http_response_code(400);
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (respond_tickets($ticket_id,$usuario_id, $mensaje_ticket, $fecha, $nombre_admin, $privilegio)) {

            cambiar_estado($estado, $ticket_id);

            $validate['success'] = true;
            $validate['message'] = 'El ticket se ha respondido correctamente';
        } else {
            http_response_code(500);
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El ticket no se ha respondido correctamente';
        }
    }
} else {
    http_response_code(400);
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The ticket data was not provided in the request';
}
header('Content-type: application/json');
echo json_encode($validate);
