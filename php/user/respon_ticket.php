<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $ticket_id = $_POST['ticket_id'];
    $mensaje_ticket = $_POST['mensaje'];
    $estado = $_POST['estado'];
    $reservedWords = reservedWords();
    $fecha = date('Y-m-d');
    $admin = $_SESSION['userName'];
    $email = $_SESSION['email'];
    $row = getUserData($email);
    if (in_array(strtolower($mensaje_ticket), $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (respond_tickets($ticket_id, $mensaje_ticket, $fecha, $admin)) {

            cambiar_estado($estado, $ticket_id);

            $validate['success'] = true;
            $validate['message'] = 'El ticket se ha respondido correctamente';
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El ticket no se respondido correctamente';
        }
    }
}
echo json_encode($validate);
