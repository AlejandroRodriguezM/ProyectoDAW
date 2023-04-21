<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $userName = $_POST['userName'];
    $imageURL = $_POST['userPicture'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $reservedWords = reservedWords();
    $fecha = date('Y-m-d');
    $fechaCreacion = date('Y-m-d', strtotime(str_replace('-', '/', $fecha)));
    if (in_array(strtolower($userName), $reservedWords) || in_array(strtolower($password), $reservedWords) || in_array(strtolower($email), $reservedWords)) {
        header("HTTP/1.1 400 Bad Request");
        $validate['success'] = false;
        $validate['message'] = 'You cannot use system reserved words';
    } else {
        if (check_email_user($email)) {
            header("HTTP/1.1 409 Conflict");
            $validate['success'] = false;
            $validate['message'] = 'The email is already in use';
        } else if (checkUser($userName, '')) {
            header("HTTP/1.1 409 Conflict");
            $validate['success'] = false;
            $validate['message'] = 'That username already exists';
        } else {
            if (crear_usuario($userName, $email, $password)) {
                $row = obtener_datos_usuario($email);
                $id = $row['IDuser'];
                insertAbourUser($id, "No information about the user $email", $fechaCreacion);
                createDirectory($email, $id);
                saveImage($email, $id);
                insertURL($email, $id);
                header("HTTP/1.1 201 Created");
                $validate['success'] = true;
                $validate['message'] = 'The user has been created successfully';
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
echo json_encode($validate);
