<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $userName = $_POST['userName'];
    $imageURL = $_POST['userPicture'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $row = getUserData($email);
    $id = $row['IDuser'];
    $reservedWords = reservedWords();
    if (in_array(strtolower($userName), $reservedWords) || in_array(strtolower($password), $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    }else {
        if (update_user($userName, $email, $password)) {
            saveImage($email,$id);
            insertURL($email,$id);
            $row = getUserData($email);
            if ($row['privilege'] == 'admin') {
                cookiesAdmin($email, $password);
            }
            cookiesUser($email, $password);
            
            $validate['success'] = true;
            $validate['message'] = 'The user save correctly';
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The user dont save correctly';
        }
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The user is not save in database';
}
echo json_encode($validate);
