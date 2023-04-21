<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];
$id_comentario = $_POST['id_comentario'];

$validate['success'] = array('success' => false, 'message' => "");

if ($userPrivilege != 'guest') {
    if ($_POST) {
        if (eliminar_comentario_comic($id_comentario)) {
            $validate['success'] = true;
            $validate['message'] = 'El comentario se ha eliminado correctamente';
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido eliminar el comentario';
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar el comentario';
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder eliminar una lista';
}
header('Content-type: application/json');
echo json_encode($validate);
