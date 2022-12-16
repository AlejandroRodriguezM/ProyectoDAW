<?php
session_start();
include_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $validate['success'] = true;
    $validate['message'] = 'Welcome to the internet guest user!';
    $validate['userName'] = "Guest";
    $_SESSION['hour'] = date("H:i", time());
    $_SESSION['email'] = $email;
    createCookies($email, $pass);
}

echo json_encode($validate);
