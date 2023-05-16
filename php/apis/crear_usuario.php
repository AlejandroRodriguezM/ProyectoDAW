<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializa el array de respuesta
$validate['success'] = array('success' => false, 'message' => "");

// Verifica si se ha enviado el formulario
if ($_POST) {
    // Obtiene los datos del formulario
    $userName = $_POST['userName'];
    $imageURL = $_POST['userPicture'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $reservedWords = reservedWords();
    $fecha = date('Y-m-d');
    $fechaCreacion = date('Y-m-d', strtotime(str_replace('-', '/', $fecha)));
    $id_activacion = uniqid();

    // Verifica si el nombre de usuario, contraseña o correo electrónico contienen palabras reservadas
    if (in_array(strtolower($userName), $reservedWords) || in_array(strtolower($password), $reservedWords) || in_array(strtolower($email), $reservedWords)) {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'You cannot use system reserved words';
    } else {
        // Verifica si el correo electrónico ya está en uso
        if (check_email_user($email)) {
            header("HTTP/1.1 409 Conflict");
            $validate['success'] = false;
            $validate['message'] = 'The email is already in use';
        } else if (checkUser($userName, '')) {
            // Verifica si el nombre de usuario ya existe
            header("HTTP/1.1 409 Conflict");
            $validate['success'] = false;
            $validate['message'] = 'That username already exists';
        } else {
            // Crea un nuevo usuario
            if (crear_usuario($userName, $email, $password, $id_activacion)) {
                $row = obtener_datos_usuario($email);
                $id = $row['IDuser'];
                enviar_correo_activacion($email, $id_activacion);
                insertAbourUser($id, "No hay informacion del usuario $userName", $fechaCreacion);
                createDirectory($email, $id);
                saveImage($email, $id);
                insertURL($email, $id);
                header("HTTP/1.1 201 Created");
                $validate['success'] = true;
                $validate['message'] = 'Revisa tu correo y activa tu cuenta';
            } else {
                header("HTTP/1.1 500 Internal Server Error");
                $validate['success'] = false;
                $validate['message'] = 'There was an error creating the user';
            }
        }
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    $validate['success'] = false;
    $validate['message'] = 'The user was not saved in the database';
}
header('Content-type: application/json');
// Devuelve la respuesta en formato JSON
echo json_encode($validate);
