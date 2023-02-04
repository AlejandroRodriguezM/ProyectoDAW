<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_user = $_POST['idUser'];
    $asunto_ticket = $_POST['asunto_ticket'];
    $descripcion_ticket = $_POST['mensaje'];
    $estado = 'Abierto';
    $reservedWords = reservedWords();
    $fecha = date('Y-m-d H:i:s');
    $fechaCreacion = date('Y-m-d', strtotime(str_replace('-', '/', $fecha)));
    if (in_array(strtolower($asunto_ticket), $reservedWords) || in_array(strtolower($descripcion_ticket), $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (new_ticket($id_user, $asunto_ticket, $descripcion_ticket, $fecha, $estado)) {
            $validate['success'] = true;
            $validate['message'] = 'El ticket se ha mandado correctamente';
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El ticket no se ha podido mandar';
        }
    }
}
echo json_encode($validate);
