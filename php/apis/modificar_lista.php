<?php
session_start();
include_once '../inc/header.inc.php';

// Obtener el correo electrónico del usuario de la sesión
$email = $_SESSION['email'];

// Obtener los datos del usuario
$userData = obtener_datos_usuario($email);

// Obtener el privilegio del usuario
$userPrivilege = $userData['privilege'];

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    // Verificar si el privilegio del usuario no es "guest"
    if ($userPrivilege != 'guest') {

        $id_lista = $_POST['id_lista'];
        $nombre_lista = $_POST['nombre_lista'];

        // Obtener las palabras reservadas del sistema
        $reservedWords = reservedWords();

        // Verificar si el nombre de la lista contiene una palabra reservada
        if (in_array(strtolower($nombre_lista), $reservedWords)) {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No puedes utilizar palabras reservadas del sistema.';
            header("HTTP/1.1 400 Bad Request");
        } else {
            // Modificar la lista
            if (modificar_lista($id_lista, $nombre_lista)) {
                $validate['success'] = true;
                $validate['message'] = 'Lista modificada correctamente';
                header("HTTP/1.1 200 OK");
            } else {
                header("HTTP/1.1 400 Bad Request");
                $validate['success'] = false;
                $validate['message'] = 'ERROR. La lista no se ha modificado correctamente';
            }
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. La lista no se ha modificado correctamente';
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para poder modificar una lista';
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
