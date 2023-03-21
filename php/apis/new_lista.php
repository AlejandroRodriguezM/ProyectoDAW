<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_user = $_POST['id_user'];
    $nombre_lista = $_POST['nombre_lista'];
    $reservedWords = reservedWords();
    if (in_array(strtolower($nombre_lista), $reservedWords)) {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cannot use system reserved words as list name';
    } else {
        if (nueva_lista($id_user,$nombre_lista)) {
            $validate['success'] = true;
            $validate['message'] = 'The list has been created successfully';
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The list could not be created';
        }
    }
} else {
    header("HTTP/1.1 400 Bad Request");// Bad Request
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The list was not saved to the database';
}
echo json_encode($validate);
