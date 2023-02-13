<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_user = $_POST['id_user'];
    $nombre_lista = $_POST['nombre_lista'];
    $reservedWords = reservedWords();
    if (in_array(strtolower($nombre_lista), $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (nueva_lista($id_user,$nombre_lista)) {
            $validate['success'] = true;
            $validate['message'] = 'La lista se ha creado correctamente';
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido crear la lista';
        }
    }
}
echo json_encode($validate);
