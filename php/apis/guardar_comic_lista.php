<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    // Obtener los datos del formulario
    $id_comic = $_POST['id_comic'];
    $id_lista = $_POST['id_lista'];

    // Verificar si se ha enviado una solicitud POST
    if (guardar_comic_lista($id_comic, $id_lista)) {
        $validate['success'] = true;
        header("HTTP/1.1 200 OK");
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido guardar el cómic';
        header("HTTP/1.1 500 Internal Server Error");
    }
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
