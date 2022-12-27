<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $userName = $_POST['userName'];
    $password = $_COOKIE['passwordUserTemp'];
    $emailOld = $_COOKIE['loginUserTemp'];
    $emailNew = $_POST['email'];
    $image = $_POST['userPicture'];
    $row = getUserData($emailOld);
    $id = $row['IDuser'];
    if(empty($image)){
        $image = $row['userPicture'];
    }
    $reservedWords = reservedWords();
    if (in_array(strtolower($userName), $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } elseif ($emailOld == $emailNew) {
        if (update_user($userName, $emailOld, $password)) {
            updateSaveImage($emailNew, $image);
            $validate['success'] = true;
            $validate['message'] = 'The user save correctly';
        }
    } elseif (checkEmail($emailNew)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. The email is used';
    } else {
        if (update_user($userName, $emailOld, $password)) {
            if($row['privilege'] == 'admin'){
                unset($_SESSION['email']);
                $_SESSION['email'] = $emailNew;
                cookiesUser($emailNew, $password);
                cookiesAdmin($emailNew, $password);
            }
            update_email($emailNew, $emailOld);
            createDirectory($emailNew, $id);
            updateSaveImage($emailNew, $image);
            insertURL($emailNew, $id);
            destroyCookiesUserTemporal();
            deleteDirectory($emailOld, $id);
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
