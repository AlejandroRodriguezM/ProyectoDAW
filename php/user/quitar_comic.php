<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_user = $_POST['id_user'];
    $id_comic = $_POST['id_comic'];

    if (quitar_comic($id_user,$id_comic)) {
        $validate['success'] = true;
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido guardar el comic';
    }
}
echo json_encode($validate);