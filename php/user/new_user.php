<?php

include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    global $conection;

    $userName = $_POST['userName'];
    $imageURL = $_POST['userPicture'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $reservedWords = reservedWords();
    if (in_array(strtolower($userName), $reservedWords) || in_array(strtolower($password), $reservedWords) || in_array(strtolower($email), $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (checkUser($email, $password)) {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The email is used';
        } else {
            if ($userName)
                if (new_user($userName, $email, $password)) {
                    saveImage();
                    insertURL($email);
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
