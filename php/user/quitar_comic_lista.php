<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_comic = $_POST['id_comic'];
    $id_lista = $_POST['id_lista'];

    if (quitar_comic_lista($id_comic,$id_lista)) {
        $validate['success'] = true;
        $validate['message'] = 'El comic se ha quitado correctamente';
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido quitar el comic';
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. El comic no se ha quitado de la lista';
}
header('Content-type: application/json');
echo json_encode($validate);