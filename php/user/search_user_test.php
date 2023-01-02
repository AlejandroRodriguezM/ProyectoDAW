<?php
session_start();
include_once '../inc/header.inc.php';


$registros = searchUser("admin");
$user = $registros->fetch();
$users = array();
while ($user != null) {
    $users[] = $user;
    $user = $registros->fetch();
}


echo json_encode($users);
