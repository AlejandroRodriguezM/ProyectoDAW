<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_lista = $_POST['id_lista'];
    $nombre_lista = $_POST['nombre_lista'];
    $reservedWords = reservedWords();
    if (in_array(strtolower($nombre_lista), $reservedWords)) {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cannot use system reserved words as list name';
    } else {
        if (modificar_lista($id_lista,$nombre_lista)) {
            $validate['success'] = true;
            $validate['message'] = 'Lista modificada correctamente';
        } else {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. La lista no se ha modificado correctamente';
        }
    }
} else {
    header("HTTP/1.1 400 Bad Request");// Bad Request
    $validate['success'] = false;
    $validate['message'] = 'ERROR. La lista no se ha modificado correctamente';
}
echo json_encode($validate);
