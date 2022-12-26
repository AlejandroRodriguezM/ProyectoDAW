<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $userName = $_POST['userName'];
    $password = $_COOKIE['passwordUserTemp'];
    $emailOld = $_COOKIE['loginUserTemp'];
    $emailNew = $_POST['email'];
    $imageURL = $_POST['userPicture'];
    $row = getUserData($emailOld);
    if(empty($imageURL)){
        $imageURL = $row['userPicture'];
    }else{
        $imageURL = $_POST['userPicture'];
    }
    
    $id = $row['IDuser'];
    $reservedWords = reservedWords();
    if (in_array(strtolower($userName), $reservedWords) || in_array(strtolower($password), $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } elseif ($emailOld == $emailNew) {
        if (update_user($userName, $emailOld, $password)) {
            saveImage($emailNew, $id);
            destroyCookiesUserTemporal();
            $validate['success'] = true;
            $validate['message'] = 'The user save correctly';
        }
    } elseif (checkEmail($emailNew)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. The email is used';
    } else {
        if (update_user($userName, $emailOld, $password)) {
            update_email($emailNew, $emailOld);
            createDirectory($emailNew, $id);
            saveImage($emailNew, $id);
            insertURL($emailNew, $id);
            destroyCookiesUserTemporal();
            deleteDirectory($emailOld, $id);

            if($row['privilege'] == 'admin'){
                unset($_SESSION['email']);
                $_SESSION['email'] = $emailOld;
                cookiesUser($emailNew, $password);
                cookiesAdmin($emailNew, $password);
            }
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
