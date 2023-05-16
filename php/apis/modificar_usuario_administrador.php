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
        $nuevo_nombre_cuenta = $_POST['nombre_cuenta'];
        $nuevo_nombre_usuario = $_POST['nombre_usuario'];
        $nuevo_apellido_usuario = $_POST['apellido_usuario'];
        $nuevo_mail_usuario = $_POST['email'];
        $id_usuario = $_POST['id_usuario'];
        $image = $_POST['userPicture'];

        // Obtener los datos del usuario a modificar
        $datos_usuario = obtener_datos_usuario($id_usuario);
        $antiguo_mail = $datos_usuario['email'];
        $antiguo_nombre_cuenta = $datos_usuario['userName'];
        $password = obtain_password($antiguo_mail);
        $informacion_usuario = getInfoAboutUser($id_usuario);
        $descripcion_usuario = $informacion_usuario['infoUser'];

        // Obtener las palabras reservadas del sistema
        $reservedWords = reservedWords();

        if ($nuevo_nombre_cuenta == $antiguo_nombre_cuenta) {
            $userName = $datos_usuario['userName'];
        }
        if (empty($image)) {
            $image = $datos_usuario['userPicture'];
        }

        // Verificar si el nuevo nombre de cuenta ya existe
        if (checkUser($nuevo_nombre_cuenta, '') && $nuevo_nombre_cuenta != $antiguo_nombre_cuenta) {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. Ese nombre de usuario ya existe';
            header("HTTP/1.1 400 Bad Request");
        } elseif (in_array(strtolower($nuevo_nombre_cuenta), $reservedWords)) {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No puedes utilizar palabras reservadas del sistema';
            header("HTTP/1.1 400 Bad Request");
        } elseif ($antiguo_mail == $nuevo_mail_usuario) {
            // Actualizar el usuario con el nuevo nombre de cuenta y correo electrónico
            if (actualizar_usuario($nuevo_nombre_cuenta, $nuevo_mail_usuario, $password)) {
                updateSaveImage($nuevo_mail_usuario, $image);
                updateAboutUser($id_usuario, "", $nuevo_nombre_usuario, $nuevo_apellido_usuario);
                $validate['success'] = true;
                $validate['message'] = 'El usuario se ha guardado correctamente';
                header("HTTP/1.1 200 OK");
            } else {
                $validate['success'] = false;
                $validate['message'] = 'ERROR. El usuario no se ha guardado correctamente';
                header("HTTP/1.1 400 Bad Request");
            }
        } elseif (check_email_user($nuevo_mail_usuario)) {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. El correo electrónico ya está en uso';
            header("HTTP/1.1 400 Bad Request");
        } else {
            // Actualizar el usuario con el nuevo nombre de cuenta, correo electrónico y otros datos
            if (actualizar_usuario($nuevo_nombre_cuenta, $antiguo_mail, $password)) {
                if ($datos_usuario['privilege'] == 'admin') {
                    unset($_SESSION['email']);
                    $_SESSION['email'] = $nuevo_mail_usuario;
                }
                updateAboutUser($id_usuario, $descripcion_usuario, $nuevo_nombre_usuario, $nuevo_apellido_usuario);
                actualizar_email($nuevo_mail_usuario, $antiguo_mail);
                createDirectory($nuevo_mail_usuario, $id_usuario);
                updateSaveImage($nuevo_mail_usuario, $image);
                insertURL($nuevo_mail_usuario, $id_usuario);
                deleteDirectory($antiguo_mail, $id_usuario);
                $validate['success'] = true;
                $validate['message'] = 'El usuario se ha actualizado';
                header("HTTP/1.1 200 OK");
            } else {
                $validate['success'] = false;
                $validate['message'] = 'ERROR. El usuario no se ha guardado correctamente';
                header("HTTP/1.1 400 Bad Request");
            }
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. El usuario no se ha guardado en la base de datos';
        header("HTTP/1.1 400 Bad Request");
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes iniciar sesión para modificar un usuario';
    header("HTTP/1.1 400 Bad Request");
}

// Establecer el encabezado y devolver la respuesta en formato JSON
header('Content-type: application/json');
echo json_encode($validate);
