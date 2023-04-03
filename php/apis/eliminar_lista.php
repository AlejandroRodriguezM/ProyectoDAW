<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");

if ($userPrivilege != 'guest') {
    if ($_POST) {
        $id_lista = $_POST['id_lista'];
        $id_user = $_POST['id_user'];

        if (eliminar_lista($id_lista, $id_user)) {
            $validate['success'] = true;
            $validate['message'] = 'La lista se ha eliminado correctamente';
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido eliminar la lista';
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar la lista';
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder eliminar una lista';
}
header('Content-type: application/json');
echo json_encode($validate);
