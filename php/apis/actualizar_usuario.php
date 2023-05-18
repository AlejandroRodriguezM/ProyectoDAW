<?php
session_start(); // Inicia o reanuda una sesión en PHP.

include_once '../inc/header.inc.php'; // Incluye un archivo de cabecera común.

$validate['success'] = array('success' => false, 'message' => ""); // Inicializa un arreglo de validación con valores predeterminados.

if ($_POST) {
    // Verifica si se ha enviado una solicitud POST.
    $email = $_POST['email'];
    $name = $_POST['userName'];
    $lastname = $_POST['lastnameUser'];
    $row = obtener_datos_usuario($email); // Obtiene los datos del usuario basados en el correo electrónico.
    $image = $_POST['userPicture'];
    if (empty($image)) {
        $image = $row['userPicture'];
    }
    $userName = $_POST['nameUser'];
    $oldUserName = $row['nameUser'];
    $emailOld = $_SESSION['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Genera un hash de la contraseña proporcionada.
    if ($userName == $oldUserName) {
        $userName = $row['nameUser'];
    }
    $id = $row['IDuser'];
    $infoUser = $_POST['field'];
    if (empty($infoUser)) {
        $infoUser = "No se han introducido datos";
    }
    $reservedWords = reservedWords(); // Obtiene una lista de palabras reservadas del sistema.

    if (checkUser($userName, '') && $userName != $oldUserName) {
        // Verifica si el nombre de usuario ya existe en la base de datos.
        $validate['success'] = false;
        $validate['message'] = 'ERROR. El usuario ya existe';
        header('HTTP/1.1 409 Conflict'); // Se establece el código de respuesta HTTP a 409 (conflicto).
    } else {
        if (in_array(strtolower($userName), $reservedWords) || in_array(strtolower($password), $reservedWords) || in_array(strtolower($name), $reservedWords) || in_array(strtolower($lastname), $reservedWords)) {
            // Verifica si el nombre de usuario o la contraseña coinciden con las palabras reservadas del sistema.
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No puedes utilizar palabras reservadas del sistema.';
            header('HTTP/1.1 400 Bad Request'); // Se establece el código de respuesta HTTP a 400 (solicitud incorrecta).
        } else {
            if (actualizar_usuario($userName, $email, $password)) {
                // Si la actualización del usuario en la base de datos tiene éxito.
                updateSaveImage($email, $image);
                insertURL($email, $id);
                $row = obtener_datos_usuario($email);
                updateAboutUser($id, $infoUser, $name, $lastname);
                $validate['success'] = true;
                $validate['message'] = 'Usuario actualizado correctamente';
                header('HTTP/1.1 200 OK'); // Se establece el código de respuesta HTTP a 200 (éxito).
            } else {
                // Si la actualización del usuario en la base de datos falla.
                $validate['success'] = false;
                $validate['message'] = 'ERROR. No se ha podido actualizar el usuario';
                header('HTTP/1.1 500 Internal Server Error'); // Se establece el código de respuesta HTTP a 500 (error interno del servidor).
            }
        }
    }
} else {
    // Si no se ha enviado una solicitud POST.
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No se ha podido actualizar el usuario';
    header('HTTP/1.1 400 Bad Request'); // Se establece el código de respuesta HTTP a 400 (solicitud incorrecta).
}
header('Content-type: application/json');
echo json_encode($validate);
