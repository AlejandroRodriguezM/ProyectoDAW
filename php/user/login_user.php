<?php
session_start();
include_once '../inc/header.inc.php';


$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_encrypted = obtain_password($email);
    $reservedWords = reservedWords();
    if (in_array($pass, $reservedWords) || in_array($email, $reservedWords)) {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. You cant use system reserved words';
    } else {
        if (password_verify($pass, $pass_encrypted)) {
            if (checkUser($email, $pass_encrypted)) {
                $row = getUserData($email);
                $validate['success'] = true;
                $validate['message'] = 'Welcome to the internet ' . $row['userName'];
                $validate['userName'] = strtoupper($row['userName']);
                $_SESSION['hour'] = date("H:i", time());
                $_SESSION['email'] = $row['email'];
                createCookies($email, $pass_encrypted);
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
