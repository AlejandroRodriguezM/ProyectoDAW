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

// Verificar si el privilegio del usuario no es "guest"
if ($userPrivilege != 'guest') {
    if ($_POST) {
        $id_user = $_POST['id_user'];
        $nombre_lista = $_POST['nombre_lista'];

        // Obtener las palabras reservadas del sistema
        $reservedWords = reservedWords();

        // Verificar si el nombre de lista contiene palabras reservadas del sistema
        if (in_array(strtolower($nombre_lista), $reservedWords)) {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No puedes utilizar palabras reservadas del sistema.';
        } else {
            // Crear la nueva lista
            if (nueva_lista($id_user, $nombre_lista)) {
                $validate['success'] = true;
                $validate['message'] = 'La lista se ha creado correctamente';
            } else {
                header("HTTP/1.1 400 Bad Request");
                $validate['success'] = false;
                $validate['message'] = 'ERROR. No se pudo crear la lista';
            }
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. La lista no se ha guardado en la base de datos';
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para crear una lista';
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
