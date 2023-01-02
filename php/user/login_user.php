<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $acceso = $_POST['acceso'];
    $pass = $_POST['pass'];
    if (!checkUserName($acceso)) {
        $validate['success'] = false;
        $validate['message'] = 'The user name/email is not valid';
    } else {
        $pass_encrypted = obtain_password($acceso);
        $reservedWords = reservedWords();
        if (password_verify($pass, $pass_encrypted)) {
            if (checkUser($acceso, $pass_encrypted)) {
                $row = getUserData($acceso);
                $email = $row['email'];
                if ($row['privilege'] == 'admin') {
                    cookiesAdmin($email, $pass_encrypted);
                }
                $validate['success'] = true;
                $validate['message'] = 'Welcome to the internet ' . $row['userName'];
                $validate['userName'] = strtoupper($row['userName']);
                $_SESSION['hour'] = date("H:i", time());
                $_SESSION['email'] = $row['email'];
                cookiesUser($email, $pass_encrypted);
            } else {
                $validate['success'] = false;
                $validate['message'] = 'ERROR. The user is not save in database';
            }
        } else {
            $validate['success'] = false;
            $validate['message'] = 'The password dosent match';
        }
    }
}

echo json_encode($validate);
