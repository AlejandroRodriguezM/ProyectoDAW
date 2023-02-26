<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_comic = $_POST['id_comic'];
    $id_lista = $_POST['id_lista'];
    if (guardar_comic_lista($id_comic,$id_lista)) {
        $validate['success'] = true;
        header("HTTP/1.1 200 OK");
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido guardar el cómic';
        header("HTTP/1.1 500 Internal Server Error");
    }
}
echo json_encode($validate);
