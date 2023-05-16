<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $id_comic = $_POST['id_comic'];
    $id_lista = $_POST['id_lista'];

    // Quitar el comic de la lista llamando a la función "quitar_comic_lista()"
    if (quitar_comic_lista($id_comic, $id_lista)) {
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

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
