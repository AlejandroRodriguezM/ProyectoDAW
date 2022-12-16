<?php

include_once '../inc/header.inc.php';


$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    global $conection;
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_encrypted = obtain_password($email);
    if (password_verify($pass, $pass_encrypted)) {
        $sql = "SELECT * FROM users where email = '$email' and password = '$pass_encrypted'";
        $result = $conection->query($sql);
        $row_count = $result->rowCount();
        if ($row_count > 0) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $validate['success'] = true;
            $validate['message'] = 'Welcome to the internet ' . $row['userName'];
            $validate['userName'] = strtoupper($row['userName']);
            $_SESSION['hour'] = date("H:i", time());
            createCookies($email, $pass_encrypted);
        } else {
            $validate['success'] = false;
            $validate['message'] = 'ERROR. The user is not save in database';
            deleteCookies();
        }
    }
     else {
        $validate['success'] = false;
        $validate['message'] = 'The password dosent match';
        deleteCookies();
    }
}

echo json_encode($validate);
