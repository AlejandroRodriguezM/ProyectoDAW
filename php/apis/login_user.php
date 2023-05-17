<?php
session_start();
include_once '../inc/header.inc.php';

// Inicializar el array de respuesta
$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $acceso = $_POST['acceso'];
    $pass = $_POST['pass'];

    // Verificar si el usuario existe en la base de datos
    if (!obtener_datos_usuario($acceso)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. El usuario no existe';
        header("HTTP/1.1 404 Not Found");
    } else {
        $pass_encrypted = obtain_password($acceso);
        $reservedWords = reservedWords();

        // Verificar si la contraseña coincide con la contraseña almacenada
        if (password_verify($pass, $pass_encrypted)) {
            if (checkUser($acceso, $pass_encrypted)) {
                $row = obtener_datos_usuario($acceso);
                $email = $row['email'];

                // Reactivar la cuenta del usuario
                reactivar_cuenta($email);

                // Establecer los datos de sesión del usuario
                $_SESSION['email'] = $row['email'];

                // Establecer la respuesta de éxito con el mensaje de bienvenida y el nombre de usuario
                $validate['success'] = true;
                $validate['message'] = '¡Bienvenido a comic Web usuario , ' . $row['userName'] . '!';
                $validate['userName'] = strtoupper($row['userName']);
                header("HTTP/1.1 200 OK");
            } else {
                $validate['success'] = false;
                $validate['message'] = 'ERROR. El usuario no existe';
                header("HTTP/1.1 404 Not Found");
            }
        } else {
            $validate['success'] = false;
            $validate['message'] = 'La contraseña no coincide';
            header("HTTP/1.1 401 Unauthorized");
        }
    }
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
