<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_user = $_POST['id_user'];
    $id_comic = $_POST['id_comic'];

    if (guardar_comic($id_user,$id_comic)) {
        $validate['success'] = true;
        header("HTTP/1.1 200 OK");
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido guardar el cómic';
        header("HTTP/1.1 500 Internal Server Error");
    }
}
echo json_encode($validate);
