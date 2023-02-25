<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "");

if ($_POST) {
    $email = $_POST['email'];
    $name = $_POST['nameUser'];
    $lastname = $_POST['lastnameUser'];
    $row = getUserData($email);
    $image = $_POST['userPicture'];
    if (empty($image)) {
        $image = $row['userPicture'];
    }
    $userName = $_POST['userName'];
    $oldUserName = $row['userName'];
    $emailOld = $_SESSION['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    if ($userName == $oldUserName) {
        $userName = $row['userName'];
    }
    $id = $row['IDuser'];
    $infoUser = $_POST['field'];
    if (empty($infoUser)) {
        $infoUser = "No se han introducido datos";
    }
    $reservedWords = reservedWords();

    if (checkUserName($userName) && $userName != $oldUserName) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. That user name alredy exist';
        header('HTTP/1.1 409 Conflict');
    } else {
        if (in_array(strtolower($userName), $reservedWords) || in_array(strtolower($password), $reservedWords)) {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. You cant use system reserved words';
            header('HTTP/1.1 400 Bad Request');
        } else {
            if (update_user($userName, $email, $password)) {
                updateSaveImage($email, $image);
                insertURL($email, $id);
                cookiesUser($email, $password);
                $row = getUserData($email);
                if ($row['privilege'] == 'admin') {
                    cookiesAdmin($email, $password);
                }
                updateAboutUser($id, $infoUser, $name, $lastname);
                $validate['success'] = true;
                $validate['message'] = 'The user save correctly';
                header('HTTP/1.1 200 OK');
            } else {
                $validate['success'] = false;
                $validate['message'] = 'ERROR. The user dont save correctly';
                header('HTTP/1.1 500 Internal Server Error');
            }
        }
    }

} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The user is not save in database';
    header('HTTP/1.1 400 Bad Request');
}
header('Content-type: application/json');
echo json_encode($validate);
