<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = getUserData($email);
$userPrivilege = $userData['privilege'];
$validate['success'] = array('success' => false, 'message' => "");

if($userPrivilege == 'admin'){
    if ($_POST) {
        $id_user = $_POST['id_user'];
        $email = $_POST['emailUser'];

        if (delete_user($email, $id_user)) {
            $validate['success'] = true;
            $validate['message'] = 'Usuario borrado correctamente';
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. No se ha podido eliminar al usuario';
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. No se ha podido eliminar la lista';
    }
}else{
    $validate['success'] = false;
    $validate['message'] = 'ERROR. No tienes permisos para eliminar usuarios';
}
header('Content-type: application/json');
echo json_encode($validate);