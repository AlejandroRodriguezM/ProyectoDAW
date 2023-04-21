<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = obtener_datos_usuario($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");
if ($userPrivilege != 'guest') {
    if ($_POST) {
        $nuevo_nombre_cuenta = $_POST['nombre_cuenta'];
        $nuevo_nombre_usuario = $_POST['nombre_usuario'];
        $nuevo_apellido_usuario = $_POST['apellido_usuario'];
        $nuevo_mail_usuario = $_POST['email'];
        $id_usuario = $_POST['id_usuario'];
        $image = $_POST['userPicture'];
        $datos_usuario = obtener_datos_usuario($id_usuario);
        $antiguo_mail = $datos_usuario['email'];
        $antiguo_nombre_cuenta = $datos_usuario['userName'];
        $password = obtain_password($antiguo_mail);
        $informacion_usuario = getInfoAboutUser($id_usuario);
        $descripcion_usuario = $informacion_usuario['infoUser'];

        $reservedWords = reservedWords();
        if ($nuevo_nombre_cuenta == $antiguo_nombre_cuenta) {
            $userName = $datos_usuario['userName'];
        }
        if (empty($image)) {
            $image = $datos_usuario['userPicture'];
        }
        if (checkUser($nuevo_nombre_cuenta,'') && $nuevo_nombre_cuenta != $antiguo_nombre_cuenta) {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. That user name already exists';
        } elseif (in_array(strtolower($nuevo_nombre_cuenta), $reservedWords)) {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. You cannot use system reserved words';
        } elseif ($antiguo_mail == $nuevo_mail_usuario) {
            if (actualizar_usuario($nuevo_nombre_cuenta, $nuevo_mail_usuario, $password)) {
                header("HTTP/1.1 200 OK");
                updateSaveImage($nuevo_mail_usuario, $image);
                updateAboutUser($id_usuario, "", $nuevo_nombre_usuario, $nuevo_apellido_usuario);
                $validate['success'] = true;
                $validate['message'] = 'The user saved correctly';
            } else {
                header("HTTP/1.1 400 Bad Request");
                $validate['success'] = false;
                $validate['message'] = 'ERROR. The user did not save correctly';
            }
        } elseif (check_email_user($nuevo_mail_usuario)) {
            header("HTTP/1.1 400 Bad Request");
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The email is already in use';
        } else {
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
                $validate['message'] = 'The user has been updated';
                header("HTTP/1.1 200 OK");
            } else {
                header("HTTP/1.1 400 Bad Request");
                $validate['success'] = false;
                $validate['message'] = 'ERROR. The user did not save correctly';
            }
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'ERROR. The user was not saved in the database';
    }
} else {
    header("HTTP/1.1 401 Unauthorized");
    $validate['success'] = false;
    $validate['message'] = 'ERROR. You must be logged in to modify a user';
}

echo json_encode($validate);
