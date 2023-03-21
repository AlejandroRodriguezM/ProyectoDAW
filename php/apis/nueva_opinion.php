<?php
session_start();
include_once '../inc/header.inc.php';
$email = $_SESSION['email'];
$userData = getUserData($email);
$userPrivilege = $userData['privilege'];

$validate['success'] = array('success' => false, 'message' => "");

if ($userPrivilege != 'guest') {
    if ($_POST) {
        $id_user = $_POST['idUser'];
        $id_comic = $_POST['idComic'];
        $opinion = $_POST['opinion'];
        $puntuacion = $_POST['puntuacion'];
        if (agregar_opinion($id_user, $id_comic, $opinion, $puntuacion)) {
            $validate['success'] = true;
            $validate['message'] = 'The opinion save correctly';
            http_response_code(200);
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The opinion dont save correctly';
            http_response_code(500);
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. The opinion is not save in database';
        http_response_code(400);
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. Debes de loguearte para poder opinar';
    header("HTTP/1.1 500 Internal Server Error");
}

echo json_encode($validate);
