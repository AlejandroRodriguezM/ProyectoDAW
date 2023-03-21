<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_lista = $_POST['id_lista'];

    if (eliminar_lista($id_lista)) {
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
header('Content-type: application/json');
echo json_encode($validate);