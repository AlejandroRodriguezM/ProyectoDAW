<?php

require_once '../inc/header.inc.php';

$validate['success'] = array('success' => false, 'message' => "", "userName" => "");

if ($_POST) {
    $email = $_POST['email'];
    $password = md5($_POST['pass']);

    $sql = "SELECT * FROM user where Email = '$email' and Pass = '$password'";
    $result = $conection->query($sql);
    $row_count = $result->rowCount();
    if ($row_count > 0) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $validate['success'] = true;
        $validate['message'] = 'Welcome to the internet '.$row['UserName'];
        $validate['userName'] = strtoupper($row['UserName']);
    } else {
        $validate['success'] = false;
        $validate['message'] = 'ERROR. This user dosent exist';
    }
} else {
    $validate['success'] = false;
    $validate['message'] = 'ERROR. The user is not save in database';
}
echo json_encode($validate);
