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
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (checkEmail($email)) {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The email is used';
        }
        if(checkUserName($userName)){
            $validate['success'] = false;
            $validate['message'] = 'ERROR. That user name alredy exist';
        } else {
            if (new_user($userName, $email, $password)) {
                $row = getUserData($email);
                $id = $row['IDuser'];
                insertAbourUser($id,"No existe información sobre el usuario $email",$fechaCreacion);
                createDirectory($email,$id);
                saveImage($email,$id);
                insertURL($email,$id);
                $validate['success'] = true;
                $validate['message'] = 'The user save correctly';
            } else {
                $validate['success'] = false;
                $validate['message'] = 'ERROR. The user dont save correctly';
            }
        }
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The user is not save in database';
}
echo json_encode($validate);
