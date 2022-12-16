<?php
session_start();
include_once '../inc/header.inc.php';


$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    global $conection;
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_encrypted = obtain_password($email);
    if (password_verify($pass, $pass_encrypted)) {
        $row_count = getUserData($email);
        if (checkUser($email, $pass_encrypted)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $validate['success'] = true;
            $validate['message'] = 'Welcome to the internet ' . $row['userName'];
            $validate['userName'] = strtoupper($row['userName']);
            $_SESSION['hour'] = date("H:i", time());
            $_SESSION['email'] = $row['email'];
            createCookies($email, $pass_encrypted);
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The user is not save in database';
            deleteCookies();
        }
    } else {
        $validate['success'] = false;
        $validate['message'] = 'The password dosent match';
        deleteCookies();
    }
}

echo json_encode($validate);
