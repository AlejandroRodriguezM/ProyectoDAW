<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_user = $_POST['id_user'];
    $id_comic = $_POST['id_comic'];

    if (quitar_comic($id_user, $id_comic)) {
        $validate['success'] = true;
        $validate['message'] = 'El comic se ha quitado correctamente';
        header("HTTP/1.1 200 OK");
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido quitar el comic';
        header("HTTP/1.1 400 Bad Request");
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. El comic no se ha quitado de la lista';
    header("HTTP/1.1 400 Bad Request");
}
header('Content-type: application/json');
echo json_encode($validate);
